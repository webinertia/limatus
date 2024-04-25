<?php

declare(strict_types=1);

namespace Limatus\View\Helper;

use Laminas\View\Helper\HtmlAttributes;
use Laminas\View\Helper\HtmlTag as BaseTag;

use function sprintf;

final class HtmlTag extends BaseTag
{
    private ?string $tag = 'div';

    public function setTag(string $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    public function openTag(string $tag = null)
    {
        if (null !== $tag) {
            $this->tag = $tag;
        }
        return sprintf(
            '<%s%s>',
            $this->tag,
            $this->htmlAttribs($this->attributes)
        );
    }

    public function hasAttributeValue(string $name, $value): bool
    {
        $helper = $this->view->plugin(HtmlAttributes::class);
        $helper = $helper($this->attributes);
    }

    public function closeTag()
    {
        return sprintf('</%s>', $this->tag);
    }
}
