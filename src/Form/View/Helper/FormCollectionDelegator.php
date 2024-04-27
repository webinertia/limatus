<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\Form\Element\Collection as CollectionElement;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;
use Laminas\Form\View\Helper\FormCollection;
use Limatus\Events;
use Limatus\Form\View\Helper\Event\RenderEvent;

final class FormCollectionDelegator extends FormCollection implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * Render a collection by iterating through all fieldsets and elements
     */
    public function render(ElementInterface $element): string
    {
        /** @var Fieldset|CollectionElement $element */

        $renderer = $this->getView();
        if ($renderer !== null && ! method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $markup         = '';
        $templateMarkup = '';
        $elementHelper  = $this->getElementHelper();
        assert(is_callable($elementHelper));

        $fieldsetHelper = $this->getFieldsetHelper();
        assert(is_callable($fieldsetHelper));

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset, $this->shouldWrap());
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $elementHelper($elementOrFieldset);
            }
        }

        if (! $this->shouldWrap) {
            return $markup . $templateMarkup;
        }

        // Every collection is wrapped by a fieldset if needed
        $attributes = $element->getAttributes();
        if (! $this->getDoctypeHelper()->isHtml5()) {
            unset(
                $attributes['name'],
                $attributes['disabled'],
                $attributes['form']
            );
        }
        $attributesString = $attributes !== [] ? ' ' . $this->createAttributesString($attributes) : '';

        $label  = $element->getLabel();
        $legend = '';

        if (! empty($label)) {
            $label = $this->translateLabel($label);
            $label = $this->escapeLabel($element, $label);

            $legend = sprintf(
                $this->labelWrapper,
                $label
            );
        }

        return sprintf(
            $this->wrapper,
            $markup,
            $legend,
            $templateMarkup,
            $attributesString
        );
    }
}
