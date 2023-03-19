<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator;

use Laminas\Form\View\Helper\FormElement;

final class FormElementDelegator extends FormElement
{
    public const DEFAULT_HELPER = 'forminput';

    /**
     * Instance map to view helper
     *
     * @var array
     */
    protected $classMap = [
        Element\Button::class         => 'formbutton',
        Element\Captcha::class        => 'formcaptcha',
        Element\Csrf::class           => 'formhidden',
        Element\Collection::class     => 'formcollection',
        Element\DateTimeSelect::class => 'formdatetimeselect',
        Element\DateSelect::class     => 'formdateselect',
        Element\MonthSelect::class    => 'formmonthselect',
    ];

    /**
     * Type map to view helper
     *
     * @var array
     */
    protected $typeMap = [
        'checkbox'       => 'formcheckbox',
        'color'          => 'formcolor',
        'date'           => 'formdate',
        'datetime'       => 'formdatetime',
        'datetime-local' => 'formdatetimelocal',
        'email'          => 'formemail',
        'file'           => 'formfile',
        'hidden'         => 'formhidden',
        'image'          => 'formimage',
        'month'          => 'formmonth',
        'multi_checkbox' => 'formmulticheckbox',
        'number'         => 'formnumber',
        'password'       => 'formpassword',
        'radio'          => 'formradio',
        'range'          => 'formrange',
        'reset'          => 'formreset',
        'search'         => 'formsearch',
        'select'         => 'formselect',
        'submit'         => 'formsubmit',
        'tel'            => 'formtel',
        'text'           => 'formtext',
        'textarea'       => 'formtextarea',
        'time'           => 'formtime',
        'url'            => 'formurl',
        'week'           => 'formweek',
    ];

    /**
     * Default helper name
     *
     * @var string
     */
    protected $defaultHelper = self::DEFAULT_HELPER;
}
