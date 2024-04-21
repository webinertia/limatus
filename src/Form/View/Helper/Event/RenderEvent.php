<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper\Event;

use Laminas\EventManager\Event;
use Laminas\Form\ElementInterface;
use Limatus\Provider\Bootstrap\LayoutMode;
use Limatus\Provider\Bootstrap\ElementClass;

final class RenderEvent extends Event
{
    private ?iterable $options;
    private ?iterable $attribs;
    private string    $markup;
    private ?string   $type;
    private ?string   $classString;
    private ?LayoutMode $layoutMode;
    private ?ElementInterface $element;

    public function setAttributes(iterable $attribs): self
    {
        $this->attribs = $attribs;
        if (isset($attribs['type']) && (ElementClass::tryFrom($attribs['type']) instanceof ElementClass)) {
            $this->setType($attribs['type']);
        }
        return $this;
    }

    public function getAttributes(): iterable
    {
        return $this->attribs;
    }

    public function setElement(?ElementInterface $element): self
    {
        $this->element = $element;
        return $this;
    }

    public function getElement(): ?ElementInterface
    {
        return $this->element;
    }

    public function setMarkup(string $markup): self
    {
        $this->markup = $markup;
        return $this;
    }

    public function getMarkup(): string
    {
        return $this->markup;
    }

    public function setOptions(iterable $options): self
    {
        $this->options = $options;
        if (isset($options['layout_mode']) && $options['layout_mode'] instanceof LayoutMode) {
            $this->setLayoutMode($options['layout_mode']);
        }
        return $this;
    }

    public function getOptions(): iterable
    {
        return $this->options;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setClassString(?string $classString): self
    {
        $this->classString = $classString;
        return $this;
    }

    public function getClassString(): ?string
    {
        return $this->classString;
    }

    public function setLayoutMode(?LayoutMode $layoutMode): self
    {
        $this->layoutMode = $layoutMode;
        return $this;
    }

    public function getLayoutMode(): ?LayoutMode
    {
        return $this->layoutMode;
    }
}
