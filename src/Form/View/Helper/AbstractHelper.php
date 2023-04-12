<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form;
use Laminas\Form\ElementInterface;
use Laminas\Form\FormInterface;
use Laminas\Form\View\Helper;

use function array_key_exists;

class AbstractHelper extends Helper\AbstractHelper
{
    protected $typeMap = [];
    /**
     * inline form css classes
     */
    protected string $inlineFormClass  = 'inline-form';
    protected string $inlineLabelClass = 'sr-only';

    /**
     * horizontal mode element wrapper
     * wrapper for all input markup when in horizontal mode
     */
    protected static string $horizontalElementWrapper = '<div %s>%s</div>';

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

    protected function getTypeClass(string $key): string|null
    {
        $type = null;
        if (array_key_exists($key, $this->typeToClassMap)) {
            $type = $this->typeToClassMap[$key];
        }
        return $type;
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
