<?php

declare(strict_types=1);

namespace Limatus\Provider\Bootstrap\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\View\HtmlAttributesSet;
use Limatus\Events;
use Limatus\Form\RenderListenerInterface;
use Limatus\Form\View\Helper\Event\RenderEvent;

final class RenderListener extends AbstractListenerAggregate implements RenderListenerInterface
{
    use ListenerAggregateTrait;

    public function __construct(
        private HtmlAttributesSet $htmlAttribs,
        private array $config
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(Events::RenderElement->value, [$this, 'onRenderElement'], 100);
        $this->listeners[] = $events->attach(Events::PostRenderElement->value, [$this, 'onPostRenderElement'], -100);
        $this->listeners[] = $events->attach(Events::PreRenderRow->value, [$this, 'onPreRenderRow'], 100);
        $this->listeners[] = $events->attach(Events::PostRenderRow->value, [$this, 'onPostRenderRow'], -100);
    }

    public function onPreRenderElement(RenderEvent $event)
    {
        $element = $event->getElement();
    }

    public function onRenderElement(RenderEvent $event)
    {
        $params = $event->getParams();
        $openingMarkup = '<div class="row">';
        $closingMarkup = '</div>';
        $rendered = $openingMarkup . $event->getMarkup() . $closingMarkup;
        return $rendered;
    }

    public function onPostRenderElement(EventInterface $event)
    {

    }

    public function onPreRenderRow(EventInterface $event)
    {

    }

    public function onPostRenderRow(EventInterface $event)
    {

    }
}
