<?php

declare(strict_types=1);

namespace Gcego\Rendering\Catalog;

use Gcego\Components\Contracts\ComponentInterface;
use Gcego\Rendering\Context\RenderContext;
use Gcego\Rendering\Contracts\RendererInterface;
use Gcego\Rendering\Contracts\StylingResolver;
use Gcego\Rendering\Exceptions\RenderException;
use Gcego\Rendering\Output\RenderResult;
use Gcego\Rendering\Renderers\ComponentRenderer;
use Gcego\Rendering\Styling\StyleSlots;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;

/**
 * Renders a gcego/components catalog or page-schema component with one of
 * the package's catalog views ("gcego-rendering::catalog.<view>").
 *
 * The component is resolved through the render's Resolution first: hidden
 * components (Hidden, HiddenWhen, VisibleOn, ...) and the children of hidden
 * containers render nothing, and computed labels, conditions and field
 * values arrive evaluated. Views receive a CatalogView as $ui next to the
 * $component, $context, $children and $styles every Blade renderer passes.
 *
 * One instance is registered per view. Its view services are resolved when
 * it renders, so the instances can be registered while the renderer registry
 * itself is being built. Applications replace any of them with
 * RendererRegistry::register() or override the view under
 * resources/views/vendor/gcego-rendering/catalog.
 */
final readonly class CatalogRenderer implements RendererInterface
{
    /**
     * Views that render nothing on their own; the parent reads them as metadata.
     */
    public const string Metadata = 'metadata';

    public function __construct(
        private Container $container,
        private string $catalogView,
    ) {}

    public function catalogView(): string
    {
        return $this->catalogView;
    }

    /**
     * The full view name ("gcego-rendering::catalog.input").
     */
    public function view(): string
    {
        return 'gcego-rendering::catalog.'.$this->catalogView;
    }

    public function render(ComponentInterface $component, RenderContext $context): RenderResult
    {
        $resolved = $context->resolution->at($context->path());

        if ($resolved === null || $resolved->hidden || $this->catalogView === self::Metadata) {
            return RenderResult::empty();
        }

        $views = $this->container->make(Factory::class);
        $styling = $this->container->make(StylingResolver::class);
        $view = $this->view();

        if (! $views->exists($view)) {
            throw RenderException::missingView($view, self::class);
        }

        $ui = new CatalogView($component, $context, $styling);

        return RenderResult::view($views->make($view, [
            'ui' => $ui,
            'component' => $component,
            'context' => $context,
            'children' => $this->container->make(ComponentRenderer::class)->children(
                $context,
                $ui->heading() === null ? $context->headingLevel : $context->nextHeadingLevel(),
            ),
            'styles' => new StyleSlots($styling, $component, $context),
        ]));
    }
}
