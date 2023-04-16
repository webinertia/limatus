<?php

declare(strict_types=1);

namespace Limatus;

use Limatus\Form\Element;
use Limatus\Form\View;
use Limatus\View\Helper;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Text;
use Laminas\Form\ElementFactory;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\Form\View\Helper\Form;
use Laminas\Form\View\Helper\FormCheckbox as FormCheckboxHelper;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\View\Helper\FormElement;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\Form\View\Helper\FormInput;
use Laminas\Form\View\Helper\FormRow;
use Laminas\Form\View\Helper\FormText;
use Laminas\ServiceManager\Factory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\View\Helper\Navigation\Menu;

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

    // Only new components need aliases
    public function getViewHelperConfig(): array
    {
        return [
            'aliases'    => [
                'formBootstrapElement'  => View\Helper\FormBootstrapElement::class,
                'formGridCollection'    => View\Helper\FormGridCollection::class,
                'formHelp'              => View\Helper\FormHelp::class,
                'formHorizontalElement' => View\Helper\FormHorizontalElement::class,
                'modal'                 => Helper\Modal::class,
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
                Helper\Modal::class                      => Factory\InvokableFactory::class,
            ],
            'delegators' => [
                Form::class               => [
                    View\Delegator\Factory\FormFactory::class,
                ],
                FormCheckboxHelper::class => [
                    View\Delegator\Factory\FormCheckboxFactory::class,
                ],
                FormCollection::class     => [
                    View\Delegator\Factory\FormCollectionFactory::class,
                ],
                FormElement::class        => [
                    View\Delegator\Factory\FormElementFactory::class,
                ],
                FormInput::class          => [
                    View\Delegator\Factory\FormInputFactory::class,
                ],
                FormRow::class            => [
                    View\Delegator\Factory\FormRowFactory::class,
                ],
                FormText::class           => [
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
            'aliases'    => [],
            'factories'  => [
                Element\Checkbox::class => ElementFactory::class,
                Element\Text::class     => ElementFactory::class,
            ],
            'delegators' => [
                Checkbox::class => [
                    Element\Delegator\Factory\CheckboxFactory::class,
                ],
                Text::class     => [
                    Element\Delegator\Factory\TextFactory::class,
                ],
            ],
        ];
    }

    public function getNavigationHelperConfig(): array
    {
        return [
            'aliases'    => [],
            'factories'  => [
                Helper\Navigation\Menu::class => InvokableFactory::class,
            ],
            'delegators' => [
                Menu::class => [
                    Helper\Navigation\Delegator\Factory\MenuFactory::class,
                ],
            ],
        ];
    }
}
