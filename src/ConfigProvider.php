<?php

declare(strict_types=1);

namespace Bootstrap;

use Bootstrap\Form\View;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\View\Helper\FormElement;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\Form\View\Helper\FormInput;
use Laminas\Form\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    public function getDependencyConfig(): array
    {
        return [];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'factories'  => [
                FormElementErrors::class          => FormElementErrorsFactory::class,
                View\Helper\Form::class           => View\Helper\Factory\FormFactory::class,
                View\Helper\FormCollection::class => View\Helper\Factory\FormCollectionFactory::class,
                View\Helper\FormElement::class    => View\Helper\Factory\FormElementFactory::class,
                View\Helper\FormInput::class      => View\Helper\Factory\FormInputFactory::class,
                View\Helper\FormRow::class        => View\Helper\Factory\FormRowFactory::class,
            ],
            'delegators' => [
                Form::class => [
                    View\Delegator\Factory\FormDelegatorFactory::class,
                ],
                FormCollection::class => [
                    View\Delegator\Factory\FormCollectionDelegatorFactory::class,
                ],
                FormElement::class => [
                    View\Delegator\Factory\FormElementDelegatorFactory::class,
                ],
                FormInput::class => [
                    View\Delegator\Factory\FormInputDelegatorFactory::class,
                ],
                FormRow::class => [
                    View\Delegator\Factory\FormRowDelegatorFactory::class,
                ],
            ],
        ];
    }

    public function getHelperConfig(): array
    {
        return [
            'bootstrap'           => [
                'attributes' => [
                    'supported_classes' => [
                        'form-group',
                        'inline-form',
                        'form-row',
                        'form-control',
                        'form-check',
                        'form-input',
                    ],
                ],
            ],
            'form_element_errors' => [
                'message_open_format'      => '<div%s><ul><li>',
                'message_separator_string' => '</li><li>',
                'message_close_string'     => '</li></ul></div>',
                'attributes'               => [
                    'class' => 'invalid-feedback',
                ],
            ],
        ];
    }

    public function getFormElementConfig(): array
    {
        return [];
    }
}
