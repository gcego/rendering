<?php

declare(strict_types=1);

namespace Gcego\Rendering\Context;

use Gcego\Components\Contracts\ComponentInterface;
use Gcego\Components\Facades\Components;
use Gcego\Components\Live\LiveSchema;
use Gcego\Components\Live\ResolvedComponent;
use Gcego\Rendering\Exceptions\InvalidRenderContextException;

/**
 * How the components of one render stand for the current state and
 * operation: visibility, computed labels and values, and field state.
 *
 * One instance is shared by every RenderContext of a render. It wraps a
 * gcego/components LiveSchema over the render root: the caller's, when the
 * host keeps one across requests (a Livewire form), or one built on first use
 * from the evaluation context ("operation", "record", ...) and empty state.
 * Renderers that never ask for it cost nothing.
 */
final class Resolution
{
    private ?LiveSchema $live;

    /**
     * @param  array<string, mixed>  $evaluation  Parameters for computed values, such as ['operation' => 'edit', 'record' => $record].
     *
     * @throws InvalidRenderContextException when $live does not hold the render root.
     */
    public function __construct(
        private readonly ComponentInterface $root,
        ?LiveSchema $live = null,
        private readonly array $evaluation = [],
    ) {
        if ($live !== null && $live->schema() !== $root) {
            throw InvalidRenderContextException::invalid('live', 'must be the live schema of the component being rendered.');
        }

        $this->live = $live;
    }

    public function live(): LiveSchema
    {
        return $this->live ??= Components::live($this->root, [], $this->evaluation);
    }

    /**
     * The resolved occurrence at a tree path, or null when it is not resolved
     * (it sits inside a hidden container).
     */
    public function at(string $path): ?ResolvedComponent
    {
        return $this->live()->at($path);
    }

    /**
     * The value a state holder currently has.
     */
    public function stateOf(ResolvedComponent $component): mixed
    {
        return $component->statePath === null ? null : $this->live()->state()->peek($component->statePath);
    }

    public function isLive(ResolvedComponent $component): bool
    {
        return $component->statePath !== null && $this->live()->isLive($component->statePath);
    }

    public function operation(): ?string
    {
        $operation = $this->evaluation['operation'] ?? null;

        return is_string($operation) ? $operation : null;
    }
}
