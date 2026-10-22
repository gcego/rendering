<?php

declare(strict_types=1);

namespace Gcego\Rendering\Catalog;

use Gcego\Components\Components\Actions;
use Gcego\Components\Components\Display;
use Gcego\Components\Components\Feedback;
use Gcego\Components\Components\Inputs;
use Gcego\Components\Components\Layout;
use Gcego\Components\Components\Media;
use Gcego\Components\Components\Navigation;
use Gcego\Components\Components\Overlays;
use Gcego\Components\Layout as Schema;
use Gcego\Rendering\Renderers\RendererRegistry;
use Illuminate\Contracts\Container\Container;

/**
 * The built-in renderers for every gcego/components catalog component and
 * page-schema container, registered as replaceable defaults: an application
 * renderer registered for the same class wins without override: true.
 */
final class CatalogRenderers
{
    /**
     * Component class => catalog view ("gcego-rendering::catalog.<view>").
     *
     * @var array<class-string, string>
     */
    public const array Views = [
        Schema\Schema::class => 'block',
        Schema\Section::class => 'block',
        Schema\Group::class => 'block',
        Schema\Item::class => 'block',

        Layout\Container::class => 'block',
        Layout\Stack::class => 'block',
        Layout\Row::class => 'block',
        Layout\Column::class => 'block',
        Layout\Grid::class => 'block',
        Layout\Splitter::class => 'block',
        Layout\Card::class => 'block',
        Layout\Panel::class => 'block',
        Layout\Fieldset::class => 'fieldset',
        Layout\Spacer::class => 'spacer',
        Layout\Tabs::class => 'tabs',
        Layout\Tab::class => 'tab',
        Layout\Accordion::class => 'accordion',
        Layout\AccordionItem::class => 'accordion-item',
        Layout\Wizard::class => 'wizard',
        Layout\WizardStep::class => 'wizard-step',

        Overlays\Modal::class => 'dialog',
        Overlays\Drawer::class => 'dialog',
        Overlays\Popover::class => 'message',
        Overlays\Tooltip::class => 'message',

        Inputs\Form::class => 'form',
        Inputs\TextInput::class => 'input',
        Inputs\EmailInput::class => 'input',
        Inputs\PasswordInput::class => 'input',
        Inputs\SearchInput::class => 'input',
        Inputs\UrlInput::class => 'input',
        Inputs\TelInput::class => 'input',
        Inputs\NumberInput::class => 'input',
        Inputs\RangeInput::class => 'input',
        Inputs\DatePicker::class => 'input',
        Inputs\DateTimePicker::class => 'input',
        Inputs\TimePicker::class => 'input',
        Inputs\ColorPicker::class => 'input',
        Inputs\FileUpload::class => 'input',
        Inputs\HiddenInput::class => 'hidden',
        Inputs\Textarea::class => 'textarea',
        Inputs\RichEditor::class => 'textarea',
        Inputs\CodeEditor::class => 'textarea',
        Inputs\Select::class => 'select',
        Inputs\MultiSelect::class => 'select',
        Inputs\Radio::class => 'radio',
        Inputs\Checkbox::class => 'checkbox',
        Inputs\Toggle::class => 'checkbox',

        Display\Text::class => 'text',
        Display\Heading::class => 'heading',
        Display\Badge::class => 'badge',
        Display\Avatar::class => 'image',
        Display\Icon::class => 'icon',
        Display\Progress::class => 'progress',
        Display\Stat::class => 'stat',
        Display\Separator::class => 'separator',
        Display\CodeBlock::class => 'code',
        Display\DescriptionList::class => 'pairs',
        Display\KeyValueList::class => 'pairs',
        Display\ListView::class => 'list',
        Display\ListItem::class => 'list-item',
        Display\Timeline::class => 'list',
        Display\TimelineItem::class => 'list-item',
        Display\Table::class => 'table',
        Display\TableColumn::class => CatalogRenderer::Metadata,

        Navigation\Menu::class => 'menu',
        Navigation\MenuItem::class => 'menu-item',
        Navigation\Breadcrumbs::class => 'breadcrumbs',
        Navigation\Breadcrumb::class => 'breadcrumb',
        Navigation\Link::class => 'link',
        Navigation\Pagination::class => 'pagination',

        Feedback\Alert::class => 'message',
        Feedback\Banner::class => 'message',
        Feedback\Toast::class => 'message',
        Feedback\EmptyState::class => 'message',
        Feedback\Skeleton::class => 'skeleton',
        Feedback\Spinner::class => 'spinner',

        Actions\Button::class => 'button',
        Actions\IconButton::class => 'button',
        Actions\SplitButton::class => 'split-button',
        Actions\ButtonGroup::class => 'button-group',
        Actions\Dropdown::class => 'dropdown',
        Actions\DropdownItem::class => 'dropdown-item',

        Media\Image::class => 'image',
        Media\Video::class => 'video',
        Media\Audio::class => 'audio',
        Media\Embed::class => 'embed',
        Media\Map::class => 'map',
        Media\Chart::class => 'chart',
        Media\Calendar::class => 'calendar',
    ];

    /**
     * Register every catalog renderer as a replaceable default. Subclasses of a
     * catalog class (an application's own SlugInput extends TextInput) use the
     * parent's renderer until they get their own.
     */
    public static function register(RendererRegistry $registry, Container $container): void
    {
        $renderers = [];

        foreach (self::Views as $component => $view) {
            $renderers[$view] ??= new CatalogRenderer($container, $view);
            $registry->registerDefault($component, $renderers[$view]);
        }
    }

    /**
     * Every view name the catalog renderers use.
     *
     * @return list<string>
     */
    public static function viewNames(): array
    {
        return array_values(array_map(
            static fn (string $view): string => 'gcego-rendering::catalog.'.$view,
            array_unique(array_diff(array_values(self::Views), [CatalogRenderer::Metadata])),
        ));
    }
}
