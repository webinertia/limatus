<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\Form\Form;
use Laminas\Form\FieldsetInterface;
use Laminas\Form\FormInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\Form\View\Helper\Form as FormHelper;
use Limatus\Events;
use Limatus\Form\View\Helper\Event\RenderEvent;

final class FormDelegator extends FormHelper implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * Render a form from the provided $form,
     * @param Form $form
     */
    public function render(FormInterface $form): string
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';

        $renderer = $this->getView();
        assert($renderer instanceof PhpRenderer);
        // what LayoutMode should this helper use?,
        $event = new RenderEvent(Events::PreRenderForm->value, $this);
        $event->setAttributes($form->getAttributes())
                ->setOptions($form->getOptions())
                ->setElement($form);

        $this->getEventManager()->triggerEvent($event);

        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent .= $renderer->formCollection($element);
            } else {
                $formContent .= $renderer->formRow($element);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }
}
