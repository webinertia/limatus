<?php

declare(strict_types=1);

namespace Bootstrap;

use Bootstrap\Form\View;
use Bootstrap\Form\Element;
use Bootstrap\Form\Gridset;
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
                'formBootstrapElement'  => View\Helper\FormBootstrapElement::class,
                'formGridCollection'    => View\Helper\FormGridCollection::class,
                'formHelp'              => View\Helper\FormHelp::class,
                'formHorizontalElement' => View\Helper\FormHorizontalElement::class,
            ],
            'factories'  => [
                FormElementErrors::class                 => FormElementErrorsFactory::class,
                View\Helper\Form::class                  => Factory\InvokableFactory::class,
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
                'gridset' => Gridset::class,
                'Gridset' => Gridset::class,
                'element' => Element::class,
                'Element' => Element::class,
                'text'    => Element\Text::class,
                'Text'    => Element\Text::class,
            ],
            'factories' => [
                Element::class      => ElementFactory::class,
                Element\Text::class => ElementFactory::class,
                Gridset::class      => ElementFactory::class,
            ],
        ];
    }
}
