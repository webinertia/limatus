<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

trait FormHelperTrait
{
    /** @var array<string, mixed> */
    protected array $config;

    /**
     * Rendering mode for Bootstrap
     * @var null|string $mode */
    protected ?string $mode;

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

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
