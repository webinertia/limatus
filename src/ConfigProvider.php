<?php

declare(strict_types=1);

namespace Bootstrap;

use Bootstrap\Form\Element;
use Bootstrap\Form\View;
use Laminas\Form\ElementFactory;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\Checkbox as CheckboxHelper;
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
                'formBootstrapElement'  => View\Helper\FormBootstrapElement::class,
                'formGridCollection'    => View\Helper\FormGridCollection::class,
                'formHelp'              => View\Helper\FormHelp::class,
                'formHorizontalElement' => View\Helper\FormHorizontalElement::class,
                'formcheckbox'          => View\Helper\FormCheckbox::class,
                'formCheckbox'          => View\Helper\FormCheckbox::class,
            ],
            'factories'  => [
                FormElementErrors::class                 => FormElementErrorsFactory::class,
                View\Helper\Form::class                  => Factory\InvokableFactory::class,
                View\Helper\FormCheckbox::class          => Factory\InvokableFactory::class,
                View\Helper\FormCollection::class        => Factory\InvokableFactory::class,
                View\Helper\FormElement::class           => Factory\InvokableFactory::class,
                View\Helper\FormInput::class             => Factory\InvokableFactory::class,
                View\Helper\FormRow::class               => Factory\InvokableFactory::class,
                View\Helper\FormText::class              => Factory\InvokableFactory::class,
                View\Helper\FormBootstrapElement::class  => Factory\InvokableFactory::class,
                View\Helper\FormGridCollection::class    => Factory\InvokableFactory::class,
                View\Helper\FormHelp::class              => Factory\InvokableFactory::class,
                View\Helper\FormHorizontalElement::class => Factory\InvokableFactory::class,
            ],
            'delegators' => [
                Form::class           => [
                    View\Delegator\Factory\FormFactory::class,
                ],
                CheckboxHelper::class => [
                    View\Delegator\Factory\FormCheckboxFactory::class,
                ],
                FormCollection::class => [
                    View\Delegator\Factory\FormCollectionFactory::class,
                ],
                FormElement::class    => [
                    View\Delegator\Factory\FormElementFactory::class,
                ],
                FormInput::class      => [
                    View\Delegator\Factory\FormInputFactory::class,
                ],
                FormRow::class        => [
                    View\Delegator\Factory\FormRowFactory::class,
                ],
                FormText::class       => [
                    View\Delegator\Factory\FormTextFactory::class,
                ],
            ],
        ];
    }

    public function getHelperConfig(): array
    {
        return [
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
            'aliases'    => [
                'checkbox' => Element\Checkbox::class,
                'Checkbox' => Element\Checkbox::class,
            ],
            'factories'  => [
                Element\Checkbox::class => ElementFactory::class,
            ],
            'delegators' => [
                Checkbox::class => [
                    Element\Delegator\Factory\CheckboxFactory::class
                ],
            ],
        ];
    }
}
