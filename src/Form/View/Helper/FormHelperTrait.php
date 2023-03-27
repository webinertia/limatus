<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\BootstrapInterface;
use Laminas\Form\ElementInterface;

use function str_contains;

trait FormHelperTrait
{
    protected bool $bootstrapped = false;
    protected ?array $bootstrapMarkup;

    /** @var array<string, mixed> */
    protected array $config;

    /**
     * Rendering mode for Bootstrap
     * @var null|string $mode */
    protected ?string $mode;

    protected function bootstrapped(
        ?ElementInterface $element = null,
    ): bool {

        if ($this->bootstrapped) {
            return $this->bootstrapped;
        }
        if ($element !== null && $element instanceof BootstrapInterface) {
            $this->bootstrapped = true;
        }
        if ($this->classCheck($element)) {
            $this->bootstrapped = true;
        }
        return $this->bootstrapped;
    }

    protected function classCheck(ElementInterface $element): bool
    {
        if (! $element->hasAttribute('class')) {
            return false;
        }
        $classString = $element->getAttribute('class');
        $supportedClasses = $this->config['supported_classes'];
        for ($i = 0; $i < count($supportedClasses); $i++) {
            if (str_contains($classString, $supportedClasses[$i])) {
                $this->bootstrapped = true;
                return true;
            }
        }
        return false;
    }

    public function setMode(string $mode): void
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

    public function configHelper(
        string $elementName,
        string $elementType,
        string $mode = BootstrapInterface::MODE_DEFAULT
    ): array|null {
        $template = [];
        $config = $this->getConfig();
        if (isset($config['templates'][$mode][$elementType][$elementName])) {
            $this->bootstrapped = true;
            $template += $config['templates'][$mode][$elementType][$elementName];
            return $template;
        }
        return [];
    }

    public function setBootstrapMarkup(array $markup): self
    {
        $this->bootstrapMarkup = $markup;
        return $this;
    }

    public function getBootstrapMarkup(): array
    {
        return $this->bootstrapMarkup;
    }
}
