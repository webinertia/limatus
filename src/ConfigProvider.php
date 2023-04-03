<?php

declare(strict_types=1);

namespace Bootstrap;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View;
use Bootstrap\Form\View\Helper;
use Bootstrap\Form\Element;
use Laminas\Form\ElementFactory;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\View\Helper\FormElement;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\Form\View\Helper\FormInput;
use Laminas\Form\View\Helper\FormRow;
use Laminas\Form\View\Helper\FormText;
use Laminas\ServiceManager\Factory;

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
            'aliases'    => [
                'bootstrap' => Helper\Bootstrapper::class,
            ],
            'factories'  => [
                FormElementErrors::class     => FormElementErrorsFactory::class,
                Helper\Bootstrapper::class   => View\Helper\BootstrapperFactory::class,
                Helper\Form::class           => Factory\InvokableFactory::class,
                Helper\FormCollection::class => Factory\InvokableFactory::class,
                Helper\FormElement::class    => Factory\InvokableFactory::class,
                Helper\FormInput::class      => Factory\InvokableFactory::class,
                Helper\FormRow::class        => Factory\InvokableFactory::class,
                Helper\FormText::class       => Factory\InvokableFactory::class,
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
                FormText::class => [
                    View\Delegator\Factory\FormTextDelegatorFactory::class,
                ],
            ],
        ];
    }

    public function getHelperConfig(): array
    {
        return [
            Helper\Bootstrapper::VHC_KEY => [
                'input_class'     => 'form-control',
                'templates'       => [
                    // expects Bootstrap::MODE_* constant as key
                    Helper\Bootstrapper::DEFAULT_MODE => [
                        // expects the elements id or name as key
                        'example' => [
                            // expects keys 'opening', 'separator', 'closing'
                            Helper\Bootstrapper::OPENING_KEY   => '<div class="%s">',
                            Helper\Bootstrapper::SEPARATOR_KEY => '%s',
                            Helper\Bootstrapper::CLOSING_KEY   => '</div>',
                        ],
                    ],
                    Helper\Bootstrapper::INLINE_MODE  => [],
                    Helper\Bootstrapper::GRID_MODE    => [],
                ],
                'supported_classes' => [
                    'form-group',
                    'inline-form',
                    'form-row',
                    'form-control',
                    'form-check',
                    'form-input',
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
        return [
            'aliases'   => [
                'element' => Element::class,
                'Element' => Element::class,
                'text'    => Element\Text::class,
                'Text'    => Element\Text::class,
            ],
            'factories' => [
                Element::class      => ElementFactory::class,
                Element\Text::class => ElementFactory::class,
            ],
        ];
    }
}
