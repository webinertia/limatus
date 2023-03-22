<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

trait FormHelperTrait
{
    protected function classCheck(ElementInterface $element): bool
    {
        $classString      = $element->getAttribute('class');
        $supportedClasses = $this->config['attributes']['supported_classes'];
        for ($i = 0; $i < count($supportedClasses); $i++) {
            if (str_contains($classString, $supportedClasses[$i])) {
                return true;
            }
        }
        return false;
    }

    protected function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}
