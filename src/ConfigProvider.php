<?php

declare(strict_types=1);

namespace Bootstrap;

use Bootstrap\Form\View;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\View\Helper\FormElementErrors;
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
        return [
            'factories' => [
                Form::class                => InvokableFactory::class,
                FormCollection::class      => InvokableFactory::class,
                FormRow::class             => InvokableFactory::class,
                View\Helper\FormRow::class => View\Helper\Factory\FormRowFactory::class,
            ]
        ];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'factories'  => [
                FormElementErrors::class => FormElementErrorsFactory::class,
            ],
            'delegators' => [
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
