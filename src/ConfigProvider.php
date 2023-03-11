<?php

declare(strict_types=1);

namespace Bootstrap;

use Laminas\Form\View\Helper\FormRow;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                FormRow::class => InvokableFactory::class,
            ]
        ];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                //FormRow::class           => InvokableFactory::class,
                FormElementErrors::class => FormElementErrorsFactory::class,
            ],
            'delegators' => [
                FormRow::class => [
                    Form\View\Helper\Factory\FormRowDelegatorFactory::class
                ],
            ],
        ];
    }

    public function getHelperConfig()
    {
        return [
            'form_element_errors' => [
                'message_open_format'      => '<div%s><ul><li>',
                'message_separator_string' => '</li><li>',
                'message_close_string'     => '</li></ul></div>',
                'attributes' => [
                    'class' => 'invalid-feedback',
                ],
            ],
        ];
    }

    public function getFormElementConfig(): array
    {
        return [
            // 'factories' => [
            //     Form\Element\Button::class            => InvokableFactory::class,
            //     Form\Element\CurrencyTextBox::class   => InvokableFactory::class,
            //     Form\Element\DateTextBox::class       => InvokableFactory::class,
            //     Form\Element\ComboBox::class          => InvokableFactory::class,
            //     Form\Element\Editor::class            => InvokableFactory::class,
            //     Form\Element\Select::class            => InvokableFactory::class,
            //     Form\Element\Submit::class            => InvokableFactory::class,
            //     Form\Element\TextBox::class           => InvokableFactory::class,
            //     Form\Element\Editor::class            => InvokableFactory::class,
            //     Form\Element\File::class              => InvokableFactory::class,
            //     Form\Element\MultiCheckbox::class     => InvokableFactory::class,
            //     Form\Element\ValidationTextBox::class => InvokableFactory::class,
            // ],
        ];
    }
}
