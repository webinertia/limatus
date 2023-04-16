<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form;
use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;

use function sprintf;

class FormInput extends AbstractHelper
{
    /**
     * DO NOT REMOVE THIS ARRAY!!!!!!!!!!!!!!!!
     * Attributes valid for the input tag
     *
     * @var array
     */
    protected $validTagAttributes = [
        'name'           => true,
        'accept'         => true,
        'alt'            => true,
        'autocomplete'   => true,
        'autofocus'      => true,
        'checked'        => true,
        'dirname'        => true,
        'disabled'       => true,
        'form'           => true,
        'formaction'     => true,
        'formenctype'    => true,
        'formmethod'     => true,
        'formnovalidate' => true,
        'formtarget'     => true,
        'height'         => true,
        'list'           => true,
        'max'            => true,
        'maxlength'      => true,
        'min'            => true,
        'multiple'       => true,
        'pattern'        => true,
        'placeholder'    => true,
        'readonly'       => true,
        'required'       => true,
        'size'           => true,
        'src'            => true,
        'step'           => true,
        'type'           => true,
        'value'          => true,
        'width'          => true,
    ];
    /**
     * Valid values for the input type
     *
     * @var array
     */
    protected $validTypes = [
        'text'           => true,
        'button'         => true,
        'checkbox'       => true,
        'file'           => true,
        'hidden'         => true,
        'image'          => true,
        'password'       => true,
        'radio'          => true,
        'reset'          => true,
        'select'         => true,
        'submit'         => true,
        'color'          => true,
        'date'           => true,
        'datetime'       => true,
        'datetime-local' => true,
        'email'          => true,
        'month'          => true,
        'number'         => true,
        'range'          => true,
        'search'         => true,
        'tel'            => true,
        'time'           => true,
        'url'            => true,
        'week'           => true,
    ];

    protected static string $horizontalWrapper = '<div %s>%s</div>';

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @template T as null|ElementInterface
     * @psalm-param T $element
     * @psalm-return (T is null ? self : string)
     * @return string|FormInput
     */
    public function __invoke(?ElementInterface $element = null)
    {
        if (! $element) {
            return $this;
        }
        return $this->render($element);
    }

    /**
     * Force an id, if possible and use the original service to do its work
     */
    public function render(ElementInterface $element): string
    {
        // force an id to prevent the input from being wrapped inside the label, we never want that
        if ($element->getName() && ! $element->hasAttribute('id')) {
            $element->setAttribute('id', $element->getName());
        }
        // default rendering handles the input attributes
        $markup = $this->defaultRender($element);
        if ($element instanceof Form\ModeAwareInterface) {
            $mode = $element->getMode();
            if (Form\ModeAwareInterface::HORIZONTAL_MODE === $mode) {
                // if this is horizontal mode we need to wrap this and use the correct attribs
                $markup = sprintf(
                    self::$horizontalWrapper,
                    $this->createAttributesString($element->getHorizontalAttributes()),
                    $markup
                );
            }
        }

        return $markup;
    }

    /**
     * Render a form <input> element from the provided $element
     *
     * @throws Exception\DomainException
     */
    public function defaultRender(ElementInterface $element): string
    {
        $name = $element->getName();
        if ($name === null || $name === '') {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes          = $element->getAttributes();
        $attributes['name']  = $name;
        $type                = $this->getType($element);
        $attributes['type']  = $type;
        $attributes['value'] = $element->getValue();
        if ('password' === $type) {
            $attributes['value'] = '';
        }

        return sprintf(
            '<input %s%s',
            $this->createAttributesString($attributes),
            $this->getInlineClosingBracket()
        );
    }
}
