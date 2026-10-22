# Changelog

All notable changes to `gcego/rendering` are documented in this file.
The project follows [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added

- Built-in renderers for every gcego/components catalog component and page-schema container (`Catalog\CatalogRenderer`, `Catalog\CatalogRenderers`, `Catalog\CatalogView`, `gcego-rendering::catalog.*` views): semantic, accessible and escaped HTML with styling slots and data attributes for style tokens.
- `Context\Resolution`: catalog components resolve visibility, computed values and field state through gcego/components' live engine. `RenderEngine::render()` accepts the host's `LiveSchema` (`live:`) or evaluation parameters (`evaluation:`), `renderAuthorized()` accepts `evaluation:`, and render operations accept an `operation` input.
- Livewire mode binds catalog fields with `wire:model` (or `wire:model.live` for fields other components depend on) to the host's `data` property.
- `RendererRegistry::registerDefault()`: replaceable built-in bindings; `RendererBinding::$isDefault` and `default` in `toArray()`.

### Changed

- `RenderingInspector` also checks the catalog views.
- Require `gcego/runtime` ^1.0 (the README listed ^0.2).

## [1.0.0] - 2026-10-22

### Added

- The rendering layer of gcego/runtime 0.1 as its own package, namespace `Gcego\Rendering`: renderers (`Renderers\RendererRegistry`, `Renderers\RendererBinding`, `Renderers\ComponentRenderer`, `Renderers\ContainerRenderer`), `Context\RenderContext`, `Context\RenderMode`, output (`Output\RenderResult`, `Output\Children`), `Blade\BladeRenderer`, styling (`StylingResolver`, `StyleSlots`, `NullStylingResolver`), state (`StatefulComponent`, `StatePath`, `StateCoordinator`), `RenderAuthorizer` with the fail-closed `GateRenderAuthorizer`, the `gcego-rendering` views and `<x-gcego-rendering::render>`.
- `RenderEngine`: `render()`, `renderAuthorized()`, `authorizedBlueprint()`, `identityOf()`, `canRender()` and `operation()`.
- `Rendering` facade (`Gcego\Rendering\Facades\Rendering`, auto-aliased) for `RenderEngine`.
- The `render` operation category in gcego/runtime's handler registry (`Contracts\RenderHandler`, `Execution\RenderOperationHandler`).
- `RenderingConfig` (`gcego-rendering.strict`, on by default outside production and overridable with `GCEGO_RENDERING_STRICT`, `.validate`, `.max_depth`, `.authorization.ability`), `RenderingInspector` and `RenderingReport`.
- `RenderingServiceProvider`, the `gcego/rendering` GCEGO package (requires core, registry, blueprints, runtime; capability `rendering`).

See the migration table in the README for renamed classes, views, settings and abilities.
