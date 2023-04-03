<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\View\Helper;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormElement as BaseHelper;
use Laminas\View\Renderer\PhpRenderer;

final class FormElement extends BaseHelper
{
    use Helper\FormHelperTrait;
    /** @var array<string, string> */
    protected $bootstrapTypeMap = [];

    public function __invoke(
        ?ElementInterface $element = null,
        ?string $mode = Helper\Bootstrapper::DEFAULT_MODE
    ) {
        if (! $element) {
            return $this;
        }
        $this->setMode($mode);

        return $this->render($element);
    }

    /**
     * Render an element
     *
     * Introspects the element type and attributes to determine which
     * helper to utilize when rendering.
     */
    public function render(ElementInterface $element): string
    {
        $renderer = $this->getView();
        if ($renderer === null || ! method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $renderedInstance = $this->renderInstance($element);

        if ($renderedInstance !== null) {
            return $renderedInstance;
        }

        $renderedType = $this->renderType($element);

        if ($renderedType !== null) {
            return $renderedType;
        }

        return $this->renderHelper($this->defaultHelper, $element);
    }

    /**
     * Render element by helper name
     */
    protected function renderHelper(string $name, ElementInterface $element): string
    {
        $renderer = $this->getView();
        assert($renderer instanceof PhpRenderer);
        $helper = $renderer->plugin($name);
        assert(is_callable($helper));
        return $helper($element, $this->mode);
    }

    /**
     * Render element by instance map
     */
    protected function renderInstance(ElementInterface $element): ?string
    {
        foreach ($this->classMap as $class => $pluginName) {
            if ($element instanceof $class) {
                return $this->renderHelper($pluginName, $element);
            }
        }

        return null;
    }

    /**
     * Render element by type map
     */
    protected function renderType(ElementInterface $element): ?string
    {
        $type = $element->getAttribute('type');

        if (isset($this->typeMap[$type])) {
            return $this->renderHelper($this->typeMap[$type], $element);
        }

        return null;
    }
}
