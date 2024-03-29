<?php

declare(strict_types=1);

namespace Limatus\Form;

interface NestedElementInterface extends ElementInterface
{
    public function setNestedElementAttribute(string $key, string|array $value): self;

    public function setNestedElementAttributes(array $nestedAttributes): self;

    public function getNestedElementAttribute(string $key): string|array|null;

    public function getNestedElementAttributes(): array;

    public function removeNestedElementAttribute(string $key): self;

    public function clearNestedElementAttributes(): self;
}
