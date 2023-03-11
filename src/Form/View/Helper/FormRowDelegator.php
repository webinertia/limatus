<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\Form\View\Helper\FormRow;

class FormRowDelegator extends FormRow
{
    protected $formRow;
    protected $eventManager;

    /**
     * The attributes for the row label
     *
     * @var array
     */
    protected $labelAttributes = ['always_wrap' => false];

    public function __construct($formRow, $eventManager)
    {
        $this->formRow       = $formRow;
        $this->eventManager = $eventManager;
    }

    public function __invoke(
        $element = null,
        ?string $labelPosition = null,
        ?bool $renderErrors = null,
        ?string $partial = null
    ) {
        return $this->render($element, $labelPosition);
    }

    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
        return parent::render($element, $labelPosition);
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();

        if ($labelPosition === null) {
            $labelPosition = $this->labelPosition;
        }

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        // Does this element have errors ?
        if ($element->getMessages() && $inputErrorClass) {
            $classAttributes  = $element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '';
            $classAttributes .= $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
        }

        if ($this->partial) {
            $vars = [
                'element'         => $element,
                'label'           => $label,
                'labelAttributes' => $this->labelAttributes,
                'labelPosition'   => $labelPosition,
                'renderErrors'    => $this->renderErrors,
            ];

            return $this->view->render($this->partial, $vars);
        }

        $elementErrors = '';
        if ($this->renderErrors) {
            $elementErrors = $elementErrorsHelper->render($element);
        }

        $elementString = $elementHelper->render($element);

        // hidden elements do not need a <label> -https://github.com/zendframework/zf2/issues/5607
        $type = $element->getAttribute('type');
        if (isset($label) && '' !== $label && $type !== 'hidden') {
            $labelAttributes = [];

            if ($element instanceof LabelAwareInterface) {
                $labelAttributes = $element->getLabelAttributes();
            }

            if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            if (
                $type === 'multi_checkbox'
                || $type === 'radio'
                || $element instanceof MonthSelect
                || $element instanceof Captcha
            ) {
                $markup = sprintf(
                    '<fieldset><legend>%s</legend>%s</fieldset>',
                    $label,
                    $elementString
                );
            } else {
                // Ensure element and label will be separated if element has an `id`-attribute.
                // If element has label option `always_wrap` it will be nested in any case.
                if (
                    $element->hasAttribute('id')
                    && ($element instanceof LabelAwareInterface && ! $element->getLabelOption('always_wrap'))
                ) {
                    $labelOpen  = '';
                    $labelClose = '';
                    $label      = $labelHelper->openTag($element) . $label . $labelHelper->closeTag();
                } else {
                    $labelOpen  = $labelHelper->openTag($labelAttributes);
                    $labelClose = $labelHelper->closeTag();
                }

                if (
                    $label !== '' && (! $element->hasAttribute('id'))
                    || ($element instanceof LabelAwareInterface && $element->getLabelOption('always_wrap'))
                ) {
                    $label = '<span>' . $label . '</span>';
                }

                // Button element is a special case, because label is always rendered inside it
                if ($element instanceof Button) {
                    $labelOpen = $labelClose = $label = '';
                }

                if ($element instanceof LabelAwareInterface && $element->getLabelOption('label_position')) {
                    $labelPosition = $element->getLabelOption('label_position');
                }

                $markup = match ($labelPosition) {
                    self::LABEL_PREPEND => $labelOpen . $label . $elementString . $labelClose,
                    default => $labelOpen . $elementString . $label . $labelClose,
                };
            }

            if ($this->renderErrors) {
                $markup .= $elementErrors;
            }
        } else {
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {
                $markup = $elementString;
            }
        }

        return $markup;
    }
}
