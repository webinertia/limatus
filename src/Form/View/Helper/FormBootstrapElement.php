<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper;

use Laminas\Form\ElementInterface as BaseInterface;
use Laminas\Form\Exception\InvalidElementException;
use Limatus\Form\Element;
use Limatus\Form\ElementInterface;
use Limatus\Form\ModeAwareInterface;
use Limatus\Form\View\Helper;

use function class_implements;
use function method_exists;
use function sprintf;

class FormBootstrapElement extends AbstractHelper
{
    /** wrapper for checkbox elements, both grid and horizontal modes */
    protected static string $checkboxWrapper = '<div class="form-check">%s</div>';
    /** wrapper for horizontal elements that have to be wrapped AGAIN and uses the
     * horizontal_attributes class */
    protected static string $horizontalCheckboxWrapper = '<div %s>%s</div>';
    protected static string $wrapper                   = '<div %s>%s%s%s</div>';
    protected Helper\FormHelp $helpText;

    public function __invoke(): self
    {
        return $this;
    }

    public function render(BaseInterface $element, string $markup, string $errorString): string
    {
        if ($element instanceof ElementInterface) {
            // do we have errors? if so let'em know
            if ($errorString !== '') {
                $element->setAttribute('class', 'is-invalid');
            }
            // ok lets sort out what mode were in
            if ($element instanceof ModeAwareInterface) {
                if ($element instanceof Element\Checkbox) {
                    $markup = sprintf(
                        self::$checkboxWrapper,
                        $markup
                    );
                    if ($element->getMode() === ModeAwareInterface::HORIZONTAL_MODE) {
                        // todo throw an exception if this is not set, we gotta have it for horizontal checkboxes
                        $markup = sprintf(
                            self::$horizontalCheckboxWrapper,
                            $this->createAttributesString($element->getHorizontalAttributes()),
                            $markup
                        );
                    }
                }
            }
            // todo: #5 validation messages are not showing for mode: horizontal
            $markup = sprintf(
                self::$wrapper,
                $this->createAttributesString($element->getBootstrapAttributes()),
                $markup,
                $this->getHelpTextHelper()->render($element),
                $errorString
            );
            // return it ready or not
            return $markup;
        } elseif ($element instanceof BaseInterface) {
            return $markup;
        }
        // we should never get here, stops phpstan from complaining
        throw new InvalidElementException(
            sprintf(
                'Expected Element implementing one of
                Limatus\\Form\\ElementInterface,
                Limatus\\Form\\NestedElementInterface,
                Laminas\\Form\\ElementInterface received %s',
                class_implements($element)
            )
        );
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
