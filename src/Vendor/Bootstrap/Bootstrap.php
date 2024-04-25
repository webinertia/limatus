<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap;

use Laminas\Form\ElementInterface;
use Limatus\Form\View\Helper\Event\RenderEvent;
use Limatus\View\Helper\HtmlTag;
use Limatus\Vendor\VendorInterface;

final class Bootstrap implements VendorInterface
{
    private ?string $markup;
    private string $optionKey = VendorInterface::class;

    public function __construct(
        private HtmlTag $tagHelper
    ) {
    }

    public function render(RenderEvent $event): ?string
    {
        return match($event->getLayoutMode()) {
            LayoutMode::Default,
            LayoutMode::Grid => $this->bootstrap($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            LayoutMode::Horizontal => $this->bootstrapHorizontal($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            LayoutMode::Inline => $this->bootstrapInline($event->getAttributes(), $event->getOptions(), $event->getMarkup()),
            default => $event->getMarkup(),
        };
    }

    protected function bootstrap(iterable $attribs, iterable $options, string $elementString): string
    {
        //$this->tagHelper->setAttributes($attribs);
        if (isset($options[$this->optionKey]['column'])) {
            if ($options[$this->optionKey]['column'] === 'col') {
                $this->tagHelper->setAttribute('class', 'col-auto');
            } else {
                $this->tagHelper->setAttribute('class', $options[$this->optionKey]['column']);
            }
        }
        // call one, wrap it in the column
        $this->markup = $this->tagHelper->openTag() . $elementString . $this->tagHelper->closeTag();
        if (isset($options[$this->optionKey]['row'])) {
            $this->tagHelper->setAttribute('class', $options[$this->optionKey]['row']);
        }
        return $this->markup;
    }

    protected function bootstrapHorizontal(iterable $attribs, iterable $options, string $elementString): string
    {
        return $this->markup;
    }

    protected function bootstrapInline(iterable $attribs, iterable $options, string $elementString): string
    {
        return $this->markup;
    }
}
