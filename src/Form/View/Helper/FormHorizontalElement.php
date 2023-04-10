<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use function sprintf;

class FormHorizontalElement extends AbstractHelper
{
    protected static string $rowWrapper = '<div class="form-group row">%s</div>';
    public function __invoke(?string $markup = null): string|self
    {
        $this->setView($this->view);
        if ($markup !== null) {
            return sprintf($markup, self::$rowWrapper);
        }
        return $this;
    }
}
