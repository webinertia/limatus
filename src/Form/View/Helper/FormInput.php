<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\BootstrapInterface;
use Bootstrap\Filter\DelimitedStringFilter;
use Bootstrap\Form\View\Helper\FormHelperTrait;
use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;
use Laminas\Form\View\Helper\FormInput as BaseInput;

use function implode;
use function sprintf;
use function strtolower;

class FormInput extends BaseInput
{
    use FormHelperTrait;

    /**
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
    public function __invoke(
        ?ElementInterface $element = null,
        ?string $mode = BootstrapInterface::MODE_DEFAULT
    ) {
        if (! $element) {
            return $this;
        }

        $this->setMode($mode);

        // bootstrap start
        $filter      = new DelimitedStringFilter(['start' => '\\[', 'end' => '\\]']);
        $elementName = $filter->filter($element->getName());
        $this->setBootstrapMarkup(
            $this->configHelper($elementName, $this->getType($element), $this->mode)
        );
        // bootstrap end

        return $this->render($element);
    }

    /**
     * Render a form <input> element from the provided $element
     *
     * @throws Exception\DomainException
     */
    public function render(ElementInterface $element): string
    {
        $markup = '';
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

        if ($this->bootstrapped($element)) {
            $markup = sprintf(
                '<input %s%s',
                $this->createAttributesString($attributes),
                $this->getInlineClosingBracket()
            );
            $wrapper = implode($this->getBootstrapMarkup());
            return sprintf($wrapper,$markup);
        }

        return sprintf(
            '<input %s%s',
            $this->createAttributesString($attributes),
            $this->getInlineClosingBracket()
        );
    }

    /**
     * Determine input type to use
     */
    protected function getType(ElementInterface $element): string
    {
        $type = $element->getAttribute('type');
        if (empty($type)) {
            return 'text';
        }

        $type = strtolower($type);
        if (! isset($this->validTypes[$type])) {
            return 'text';
        }

        return $type;
    }
}
