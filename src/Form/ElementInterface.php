<?php

declare(strict_types=1);

namespace Bootstrap\Form;

interface ElementInterface
{
    public function setBootstrapAttribute(string $key, $value): self;
    public function getBootstrapAttribute(string $key): string|null;
    public function setBootstrapAttributes(iterable $arrayOrTraversable): self;
    public function getBootstrapAttributes(): array;
    public function removeBootstrapAttribute(string $key): self;
    public function removeBootstrapAttributes(array $keys): self;
    public function hasBootstrapAttribute(string $key): bool;
    public function setBootstrapOption(string $key, string $value): self;
    public function getBootstrapOption(string $key): string|bool|null;
    public function setBootstrapOptions(array $options): self;
    public function getBootstrapOptions(): array;
    public function setHelp(string $help): self;
    public function getHelp(): ?string;
    public function setHelpAttribute(string $key, string $value): self;
    public function getHelpAttribute(string $key): string|null;
    public function setHelpAttributes(iterable $arrayOrTraversable): self;
    public function getHelpAttributes(): array;
    public function hasHelpAttribute(string $key): bool;
    public function removeHelpAttributes(array $keys): self;
    public function clearHelpAttributes(): self;
}
