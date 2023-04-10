<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form;
use Laminas\Form\FormInterface;
use Laminas\Form\View\Helper;

use function array_key_exists;
use function assert;
use function str_contains;
use function ucfirst;

class AbstractHelper extends Helper\AbstractHelper
{
    public const DEFAULT_MODE    = 'default';
    public const INLINE_MODE     = 'inline';
    public const GRID_MODE       = 'grid';
    public const HORIZONTAL_MODE = 'horizontal';

    protected ?string $mode = 'default';

    /**
     * inline form css classes
     */
    protected string $inlineFormClass  = 'inline-form';
    protected string $inlineLabelClass = 'sr-only';

    /**
     * horizontal mode element wrapper
     * wrapper for all input markup when in horizontal mode
     */
    protected string $horizontalElementWrapper = '<div class="form-group row">%s</div>';

    /**
     * Base bootstrap input element styles
     */
    protected array $typeToClassMap = [
        'select'         => 'form-control',
        'text'           => 'form-control',
        'button'         => 'btn',
        'checkbox'       => 'form-check-input',
        'file'           => 'form-control-file',
        'image'          => 'form-control',
        'password'       => 'form-control',
        'radio'          => 'form-check-input',
        'reset'          => 'btn',
        'submit'         => 'btn',
        'date'           => 'form-control',
        'datetime'       => 'form-control',
        'datetime-local' => 'form-control',
        'email'          => 'form-control',
        'month'          => 'form-control',
        'number'         => 'form-control',
        'range'          => 'form-control',
        'search'         => 'form-control',
        'tel'            => 'form-control',
        'time'           => 'form-control',
        'url'            => 'form-control',
        'week'           => 'form-control',
        'textarea'       => 'form-control',
    ];

    public function bootstrapForm(FormInterface $form, string $mode): void
    {
        if (! $form->hasAttribute('id') && $form->hasAttribute('name')) {
            $form->setAttribute('id', $this->getId($form));
        }

        if ($this->mode === self::INLINE_MODE) {
            if ($form->hasAttribute('class')) {
                $form->setAttribute('class', $form->getAttribute('class') . ' ' . $this->inlineFormClass);
            } else {
                $form->setAttribute('class', $this->inlineFormClass);
            }
        }
    }

    /** @deprecated */
    public function bootstrapElement(Form\ElementInterface $element, string $mode): void
    {
        if (! $element->hasAttribute('id')) {
            $id = $this->getId($element);
            if ($id !== null) {
                $element->setAttribute('id', $id);
            }
        }
        assert(isset($id));
        //assert($element instanceof Form\Element);
        switch (true) {
            case $mode === self::INLINE_MODE:
            case $mode === self::GRID_MODE:
                $labelAttributes = $element->getLabelAttributes();
                if (! array_key_exists('class', $labelAttributes)) {
                    $element->setLabelAttributes(['class' => $this->inlineLabelClass]);
                }
                if ($element->getLabel() !== null) {
                    $element->setAttribute('placeholder', $element->getLabel());
                } elseif ($id !== null) {
                    $element->setAttribute('placeholder', ucfirst($id));
                }
                break;
            case $mode === self::HORIZONTAL_MODE:
                break;
            default:
                // code
                break;
        }
        $this->bootstrapElementClassString($element);
    }

    /** @deprecated */
    public function bootstrapInputAttributeString(Form\ElementInterface $element): void
    {
        $class = '';
        if ($element->hasAttribute('type')) {
            $class = $this->getTypeClass($element->getAttribute('type'));
        }
        if (! $element->hasAttribute('class')) {
            // Note: we do not have to worry with the form-check-inline style classes here, they are set on the div
            $element->setAttribute('class', $class);
            return;
        }
        if ($element->hasAttribute('class')) {
            $classString = $element->getAttribute('class');
            if ($class !== '' && ! str_contains($classString, $class)) {
                $classString = $class . ' ' . $classString;
                $element->setAttribute('class', $classString);
            }
        }
    }

    protected function getTypeClass(string $key): string
    {
        if (array_key_exists($key, $this->typeToClassMap)) {
            return $this->typeToClassMap[$key];
        }
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;
        return $this;
    }
}
