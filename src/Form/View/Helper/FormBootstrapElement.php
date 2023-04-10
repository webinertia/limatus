<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\ElementInterface;
use Bootstrap\Form\View\Helper;
use Laminas\Form\ElementInterface as BaseElement;

use function method_exists;
use function sprintf;

class FormBootstrapElement extends AbstractHelper
{
    protected static string $wrapper = '<div %s>%s%s%s</div>';
    protected Helper\FormHelp $helpText;
    public function __invoke(): self
    {
        return $this;
    }

    public function render(BaseElement $element, string $markup, string $errorString): string
    {
        if ($element instanceof ElementInterface) {
            // do we have errors? if so let'em know
            if ($errorString !== '') {
                $element->setAttribute('class', 'is-invalid');
            }
            $helpText = $this->getHelpTextHelper()->render($element);
            return sprintf(
                self::$wrapper,
                $this->createAttributesString($element->getBootstrapAttributes()),
                $markup,
                $this->getHelpTextHelper()->render($element),
                $errorString
            );
        } elseif ($element instanceof BaseElement) {
            return $markup;
        }
        // we should never get here, stops phpstan from bitching
        return '';
    }

    protected function getHelpTextHelper(): Helper\FormHelp
    {
        if ($this->view !== null && method_exists($this->view, 'plugin')) {
            $this->helpText = $this->view->plugin('formHelp');
            return $this->helpText;
        }

        $this->helpText = new Helper\FormHelp();
        return $this->helpText;
    }
}
