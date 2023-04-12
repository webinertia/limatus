<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\Element;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;

use function sprintf;

class FormCheckbox extends FormInput
{
    /**
     * Render a form <input> element from the provided $element
     *
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     */
    public function render(ElementInterface $element): string
    {
        if (! $element instanceof Element\Checkbox && ! $element instanceof Checkbox) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Requires $element to one of ' . Element\Checkbox::class . ' or ' . Checkbox::class . ' recieved: %s',
                $element::class
            ));
        }

        $name = $element->getName();
        if ($name === null || $name === '') {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        // force an id so the label will not wrap
        if (! $element->hasAttribute('id')) {
            $element->setAttribute('id', $name);
        }

        $attributes          = $element->getAttributes();
        $attributes['name']  = $name;
        $attributes['type']  = $this->getInputType();
        $attributes['value'] = $element->getCheckedValue();
        $closingBracket      = $this->getInlineClosingBracket();

        if ($element->isChecked()) {
            $attributes['checked'] = 'checked';
        }

        $rendered = sprintf(
            '<input %s%s',
            $this->createAttributesString($attributes),
            $closingBracket
        );

        if ($element->useHiddenElement()) {
            $hiddenAttributes = [
                'disabled' => $attributes['disabled'] ?? false,
                'name'     => $attributes['name'],
                'value'    => $element->getUncheckedValue(),
            ];

            $rendered = sprintf(
                '<input type="hidden" %s%s',
                $this->createAttributesString($hiddenAttributes),
                $closingBracket
            ) . $rendered;
        }

        return $rendered;
    }

    /**
     * Return input type
     */
    protected function getInputType(): string
    {
        return 'checkbox';
    }
}
