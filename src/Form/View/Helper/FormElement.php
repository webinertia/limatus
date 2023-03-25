<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper;
use Laminas\Form\Element;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormElement as BaseHelper;
use Laminas\View\Renderer\PhpRenderer;

final class FormElement extends BaseHelper
{
    use Helper\FormHelperTrait;

    protected $bsTypeMap = [];

    public function __invoke(
        ?ElementInterface $element = null,
        ?string $mode = BootstrapInterface::MODE_DEFAULT
    ) {
        if (! $element) {
            return $this;
        }

        if ($element instanceof BootstrapInterface || $this->classCheck($element)) {
            return $this->render($element);
        }

        return parent::render($element);
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
}
