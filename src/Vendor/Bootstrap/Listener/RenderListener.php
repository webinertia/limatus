<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Form\View\Helper\FormLabel;
use Limatus\Events;
use Limatus\Form\RenderListenerInterface;
use Limatus\Form\View\Helper\Event\RenderEvent;
use Limatus\Vendor\Bootstrap\Bootstrap;
use Limatus\Vendor\Bootstrap\LayoutMode;
use Limatus\Vendor\VendorInterface;

final class RenderListener extends AbstractListenerAggregate implements RenderListenerInterface
{
    use ListenerAggregateTrait;

    private ?LayoutMode $layoutMode = LayoutMode::Default;

    public function __construct(
        private VendorInterface&Bootstrap $bs,
        private array $config
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(Events::PreRenderForm->value, [$this, 'onPreRenderForm'], $priority);

        $this->listeners[] = $events->attach(Events::PreRenderElement->value, [$this, 'onPreRenderElement'], $priority);
        $this->listeners[] = $events->attach(Events::RenderElement->value, [$this, 'onRenderElement'], $priority);
        $this->listeners[] = $events->attach(Events::PostRenderElement->value, [$this, 'onPostRenderElement'], $priority);

        $this->listeners[] = $events->attach(Events::PreRenderRow->value, [$this, 'onPreRenderRow'], $priority);
        $this->listeners[] = $events->attach(Events::PostRenderRow->value, [$this, 'onPostRenderRow'], $priority);
        // label listeners
        $this->listeners[] = $events->attach(Events::PreRenderLabel->value, [$this, 'onPreRenderLabel'],  $priority);
    }

    public function onPreRenderForm(RenderEvent $event)
    {
        $attribs = $event->getAttributes();
        $options = $event->getOptions();
        $this->layoutMode = $event->getLayoutMode();

    }

    public function onPreRenderRow(RenderEvent $event)
    {

    }

    public function onPostRenderRow(RenderEvent $event)
    {
        $attribs = $event->getAttributes();
        $options = $event->getOptions();
        $markup  = $event->getMarkup();
    }

    public function onPreRenderElement(RenderEvent $event)
    {
        $element = $event->getElement();
        if ($element->getAttribute('id') === null) {
            $target = $event->getTarget();
            // This call fails because of undefined method that should be available :(
            //$name = $target->getId();
            //$element->setAttribute('id', $element->getAttribute('name'));
        }
    }

    public function onRenderElement(RenderEvent $event)
    {
        return $this->bs->render($event);
    }

    public function onPostRenderElement(EventInterface $event)
    {

    }

    public function onPreRenderLabel(RenderEvent $event)
    {
        $options = $event->getOptions();
        if (! isset($options['label_options']['position'])) {
            $options['label_options']['position'] = FormLabel::PREPEND;
        }
        //return $this->bs->render($event);
    }
}
