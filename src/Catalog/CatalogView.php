<?php

declare(strict_types=1);

namespace Gcego\Rendering\Catalog;

use BackedEnum;
use Gcego\Components\Contracts\ComponentInterface;
use Gcego\Components\Live\ResolvedComponent;
use Gcego\Components\Support\SafeAttributes;
use Gcego\Components\Support\SafeUrl;
use Gcego\Components\Traversal\ComponentWalker;
use Gcego\Components\Trees\TreeNode;
use Gcego\Rendering\Context\RenderContext;
use Gcego\Rendering\Contracts\StylingResolver;
use Illuminate\Support\HtmlString;
use JsonSerializable;
use Stringable;
use UnitEnum;

/**
 * What a catalog view reads about its component ($ui in the view): resolved
 * properties, text, flags, ids, field state and escaped HTML attributes.
 *
 * Every value printed by the catalog views passes through Blade's {{ }} or
 * through attributes(), which escapes names and values; no method returns
 * unescaped markup built from component values.
 */
final readonly class CatalogView
{
    /**
     * The Livewire property catalog fields bind to in Livewire mode: wire:model="data.email".
     */
    public const string LivewireProperty = 'data';

    /**
     * Properties exposed to styling as data attributes: data-variant="primary".
     *
     * @var list<string>
     */
    private const array Tokens = [
        'variant',
        'size',
        'color',
        'status',
        'align',
        'justify',
        'gap',
        'orientation',
        'width',
        'height',
        'columns',
        'columnSpan',
        'columnStart',
        'span',
        'trigger',
        'chartType',
        'view',
    ];

    public ResolvedComponent $resolved;

    public function __construct(
        public ComponentInterface $component,
        public RenderContext $context,
        private StylingResolver $styling,
    ) {
        $this->resolved = $context->resolution->at($context->path()) ?? new ResolvedComponent(
            component: $component,
            path: $context->path(),
            containerPath: '',
            statePath: null,
            properties: [],
            hidden: false,
            label: null,
            dependencies: [],
            children: [],
        );
    }

    /**
     * A resolved property: computed values arrive evaluated, defaults applied.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return array_key_exists($key, $this->resolved->properties) ? ($this->resolved->properties[$key] ?? $default) : $this->component->get($key, $default);
    }

    /**
     * The component's name, when it has one.
     */
    public function name(): ?string
    {
        return self::nameOf($this->component);
    }

    /**
     * A property as display text, or null when it is empty or not textual.
     */
    public function text(string $key): ?string
    {
        $text = self::stringify($this->get($key));

        return $text === null || trim($text) === '' ? null : $text;
    }

    public function flag(string $key): bool
    {
        return $this->get($key) === true;
    }

    public function integer(string $key): ?int
    {
        $value = $this->get($key);

        return is_int($value) ? $value : null;
    }

    /**
     * A URL property, when it is safe to print as href or src.
     */
    public function url(string $key): ?string
    {
        $url = $this->get($key);

        return is_string($url) && SafeUrl::isSafe($url) ? $url : null;
    }

    /**
     * The explicit title or label shown as this component's heading.
     */
    public function heading(): ?string
    {
        return $this->text('title') ?? $this->text('label');
    }

    /**
     * The label, derived from the name when none is set ("first_name" reads "First name").
     */
    public function label(): ?string
    {
        return $this->resolved->label ?? $this->text('label');
    }

    /**
     * The heading level for this component's own heading (h1-h6).
     */
    public function level(): int
    {
        $level = $this->integer('level');

        return $level !== null && $level >= 1 && $level <= 6 ? $level : $this->context->headingLevel;
    }

    /**
     * The element id: the component's explicit Id, or a stable id from its
     * occurrence. With a suffix, a related id ("…-hint").
     */
    public function id(string $suffix = ''): string
    {
        $explicit = $this->component->id();

        if ($explicit === null) {
            return $this->context->domId($suffix);
        }

        return $suffix === '' ? $explicit : $explicit.'-'.trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($suffix)), '-');
    }

    /**
     * Escaped attributes for an element: id, type and path markers, styling
     * classes for $slot, data attributes for style tokens, the component's
     * extra attributes, then $extra. Null and false values are left out; true
     * prints the bare attribute name.
     *
     * @param  array<string, scalar|null>  $extra
     */
    public function attributes(array $extra = [], string $slot = 'root', bool $withId = true): HtmlString
    {
        $attributes = $withId ? ['id' => $this->id()] : [];

        if ($slot === 'root') {
            $attributes['data-gcego'] = $this->component->type();
            $attributes['data-gcego-path'] = $this->context->path();

            foreach (self::Tokens as $token) {
                $attributes += self::tokenAttributes($token, $this->get($token));
            }

            $extraAttributes = $this->get('extraAttributes');

            if (is_array($extraAttributes) && SafeAttributes::isSafe($extraAttributes)) {
                foreach ($extraAttributes as $name => $value) {
                    $attributes[(string) $name] = is_scalar($value) || $value === null ? $value : null;
                }
            }
        }

        $classes = trim(implode(' ', array_filter([
            trim((string) preg_replace('/\s+/', ' ', $this->styling->classes($this->component, $slot, $this->context))),
            is_string($attributes['class'] ?? null) ? $attributes['class'] : '',
            is_string($extra['class'] ?? null) ? $extra['class'] : '',
        ])));
        unset($extra['class']);

        $attributes = [...$attributes, ...$extra, 'class' => $classes === '' ? null : $classes];

        return new HtmlString(self::renderAttributes($attributes));
    }

    /**
     * Escaped attributes for a secondary element ("label", "hint", "title", ...): styling classes only, plus $extra.
     *
     * @param  array<string, scalar|null>  $extra
     */
    public function slot(string $slot, array $extra = []): HtmlString
    {
        return $this->attributes($extra, $slot, withId: false);
    }

    public function statePath(): ?string
    {
        return $this->resolved->statePath;
    }

    /**
     * The field's current value: its state, or its Value property outside state.
     */
    public function value(): mixed
    {
        return $this->resolved->statePath === null ? $this->get('value') : $this->context->resolution->stateOf($this->resolved);
    }

    public function valueText(): ?string
    {
        return self::stringify($this->value());
    }

    /**
     * The form field name: "address.city" submits as "address[city]".
     */
    public function inputName(): ?string
    {
        $path = $this->statePath() ?? $this->name();

        if ($path === null) {
            return null;
        }

        $segments = explode('.', $path);

        return array_shift($segments).implode('', array_map(static fn (string $segment): string => '['.$segment.']', $segments));
    }

    /**
     * wire:model (or wire:model.live for fields other components depend on) in Livewire mode.
     *
     * @return array<string, string>
     */
    public function wire(): array
    {
        if (! $this->context->isLivewire() || $this->statePath() === null) {
            return [];
        }

        $directive = $this->context->resolution->isLive($this->resolved) ? 'wire:model.live' : 'wire:model';

        return [$directive => self::LivewireProperty.'.'.$this->statePath()];
    }

    /**
     * The id of the help text, for aria-describedby, when there is one.
     */
    public function describedBy(): ?string
    {
        return $this->text('helpText') === null ? null : $this->id('hint');
    }

    /**
     * Choices as value/label pairs, marking the selected ones.
     *
     * @return list<array{value: string, label: string, selected: bool}>
     */
    public function options(): array
    {
        $options = $this->get('options');
        $current = $this->value();
        $selected = array_map(static fn (mixed $value): ?string => self::stringify($value), is_array($current) ? $current : [$current]);
        $choices = [];

        foreach (is_array($options) ? $options : [] as $value => $label) {
            $value = (string) $value;
            $choices[] = [
                'value' => $value,
                'label' => self::stringify($label) ?? $value,
                'selected' => in_array($value, $selected, true),
            ];
        }

        return $choices;
    }

    /**
     * The visible children with what a tab list, accordion or step list shows for them.
     *
     * @return list<array{index: int, id: string, title: string, icon: ?string, name: ?string, active: bool, disabled: bool}>
     */
    public function items(): array
    {
        $items = [];
        $active = $this->text('active');

        foreach ($this->childNodes() as $index => $node) {
            $resolved = $this->context->resolution->at($node->path->toString());

            if ($resolved === null || $resolved->hidden) {
                continue;
            }

            $child = new self($node->component, $this->context->child($node), $this->styling);
            $items[] = [
                'index' => $index,
                'id' => $child->id(),
                'title' => $child->heading() ?? $child->label() ?? 'Item '.($index + 1),
                'icon' => $child->text('icon'),
                'name' => self::nameOf($node->component),
                'active' => $active !== null && self::nameOf($node->component) === $active,
                'disabled' => $child->flag('disabled'),
            ];
        }

        if ($items !== [] && array_filter($items, static fn (array $item): bool => $item['active']) === []) {
            $items[0]['active'] = true;
        }

        return $items;
    }

    /**
     * Whether this component is the active child of its tabs, accordion or
     * wizard: the one its parent's Active names, or the first visible child.
     */
    public function isActiveChild(): bool
    {
        $parentPath = $this->context->node->parentPath;
        $parent = $parentPath === null ? null : $this->context->resolution->at($parentPath->toString());

        if ($parent === null) {
            return true;
        }

        $active = $parent->get('active');

        if (is_string($active) && $active !== '') {
            return $this->name() === $active;
        }

        foreach ($parent->children as $sibling) {
            if (! $sibling->hidden) {
                return $sibling->path === $this->context->path();
            }
        }

        return false;
    }

    public function parentType(): ?string
    {
        $parentPath = $this->context->node->parentPath;

        return $parentPath === null ? null : $this->context->resolution->at($parentPath->toString())?->type();
    }

    /**
     * Columns from the TableColumn children and rows from Data, as display text.
     *
     * @return array{columns: list<array{label: string, align: ?string}>, rows: list<list<string>>}
     */
    public function table(): array
    {
        $columns = [];

        foreach ($this->childNodes() as $node) {
            $resolved = $this->context->resolution->at($node->path->toString());

            if ($resolved === null || $resolved->hidden || $resolved->type() !== 'display.tableColumn') {
                continue;
            }

            $field = $resolved->get('field');
            $field = is_string($field) ? $field : $resolved->name();
            $columns[] = [
                'field' => $field,
                'label' => $resolved->label ?? (string) $field,
                'align' => is_string($resolved->get('align')) ? $resolved->get('align') : null,
            ];
        }

        $data = $this->get('data');
        $rows = [];

        foreach (is_array($data) ? $data : [] as $record) {
            $rows[] = array_map(
                static fn (array $column): string => $column['field'] === null ? '' : (self::stringify(data_get($record, $column['field'])) ?? ''),
                $columns,
            );
        }

        return [
            'columns' => array_map(static fn (array $column): array => ['label' => $column['label'], 'align' => $column['align']], $columns),
            'rows' => $rows,
        ];
    }

    /**
     * Key/value pairs of the Data property as display text.
     *
     * @return array<string, string>
     */
    public function pairs(): array
    {
        $data = $this->get('data');
        $pairs = [];

        foreach (is_array($data) ? $data : [] as $key => $value) {
            $pairs[(string) $key] = self::stringify($value) ?? '';
        }

        return $pairs;
    }

    /**
     * The pagination window: current page, page count and the pages to link.
     *
     * @return array{page: int, pages: int, links: list<int>}
     */
    public function pagination(): array
    {
        $pageSize = max(1, $this->integer('pageSize') ?? 15);
        $pages = max(1, (int) ceil(($this->integer('total') ?? 0) / $pageSize));
        $page = min($pages, max(1, $this->integer('page') ?? 1));

        return ['page' => $page, 'pages' => $pages, 'links' => range(max(1, $page - 2), min($pages, $page + 2))];
    }

    /**
     * The session's CSRF token for forms that submit with POST, or null outside a session.
     */
    public function csrfToken(): ?string
    {
        try {
            $token = csrf_token();
        } catch (\Throwable) {
            return null;
        }

        return is_string($token) && $token !== '' ? $token : null;
    }

    /**
     * Whether this occurrence's component has the given type ("layout.card").
     */
    public function is(string ...$types): bool
    {
        return in_array($this->component->type(), $types, true);
    }

    /**
     * A property as JSON for a data attribute (escaped when printed).
     */
    public function json(string $key): string
    {
        return (string) json_encode($this->get($key), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    }

    /**
     * @return list<TreeNode>
     */
    private function childNodes(): array
    {
        return app(ComponentWalker::class)->childNodes($this->context->node);
    }

    private static function nameOf(ComponentInterface $component): ?string
    {
        $name = $component->get('name');

        return is_string($name) && $name !== '' ? $name : null;
    }

    private static function stringify(mixed $value): ?string
    {
        return match (true) {
            is_string($value) => $value,
            is_int($value), is_float($value) => (string) $value,
            is_bool($value) => $value ? 'Yes' : 'No',
            $value instanceof BackedEnum => (string) $value->value,
            $value instanceof UnitEnum => $value->name,
            $value instanceof Stringable => (string) $value,
            $value instanceof JsonSerializable, is_array($value) => (string) json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR),
            default => null,
        };
    }

    /**
     * @return array<string, scalar|null>
     */
    private static function tokenAttributes(string $token, mixed $value): array
    {
        $name = 'data-'.strtolower((string) preg_replace('/(?<!^)[A-Z]/', '-$0', $token));

        if (is_array($value)) {
            $attributes = [];

            foreach ($value as $breakpoint => $breakpointValue) {
                if (is_scalar($breakpointValue)) {
                    $attributes[$breakpoint === 'default' ? $name : $name.'-'.$breakpoint] = (string) $breakpointValue;
                }
            }

            return $attributes;
        }

        $text = self::stringify($value);

        return $text === null || is_bool($value) ? [] : [$name => $text];
    }

    /**
     * @param  array<string, scalar|null>  $attributes
     */
    private static function renderAttributes(array $attributes): string
    {
        $html = '';

        foreach ($attributes as $name => $value) {
            if ($value === null || $value === false || preg_match('/\A[A-Za-z_:@][A-Za-z0-9_:.\-]*\z/', $name) !== 1) {
                continue;
            }

            $html .= $value === true ? ' '.$name : ' '.$name.'="'.e((string) $value).'"';
        }

        return $html;
    }
}
