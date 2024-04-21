<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper;

use Limatus\Provider\Bootstrap\LayoutMode;

trait HelperDelegatorTrait
{
    private LayoutMode $layoutMode = LayoutMode::Default;

    public function setLayoutMode(LayoutMode $layoutMode): void
    {
        $this->layoutMode = $layoutMode;
    }

    public function getLayoutMode(): LayoutMode
    {
        return $this->layoutMode;
    }
}
