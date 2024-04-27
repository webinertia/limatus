<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap;

use Laminas\Form\ElementInterface;
use Limatus\Form\View\Helper\Event\RenderEvent;
use Limatus\View\Helper\HtmlTag;
use Limatus\Vendor\VendorInterface;

final class Bootstrap implements VendorInterface
{
    private ?string $markup = null;
    private string $optionKey = VendorInterface::class;

    public function __construct(
        private HtmlTag $tagHelper
    ) {
    }

    public function render(RenderEvent $event): ?string
    {
        return match($event->getLayoutMode()) {
            LayoutMode::Default,
            LayoutMode::Grid => $this->grid($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            LayoutMode::Horizontal => $this->horizontal($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            LayoutMode::Inline => $this->inline($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            default => $event->getMarkup(),
        };
    }

    public function renderInput(RenderEvent $event): ?string
    {
        return $this->grid(
            $event->getAttributes(),
            $event->getOptions(),
            $event->getMarkup()
        );
    }

    protected function grid(iterable $attribs, iterable $options, string $elementString): ?string
    {
        //$this->tagHelper->setAttributes($attribs);
        if (isset($options[$this->optionKey]['column'])) {
            if ($options[$this->optionKey]['column'] === 'col') {
                $this->tagHelper->add('class', 'col-auto');
            } else {
                $this->tagHelper->add('class', $options[$this->optionKey]['column']);
            }
        }
        // wrap it in the column
        $this->markup = $this->tagHelper->openTag() . $elementString . $this->tagHelper->closeTag();

        return $this->markup;
    }

    protected function horizontal(iterable $attribs, iterable $options, string $elementString): ?string
    {
        if (isset($options[$this->optionKey]['row'])) {

        }
        return $this->markup;
    }

    protected function inline(iterable $attribs, iterable $options, string $elementString): ?string
    {
        return $this->markup;
    }
}
