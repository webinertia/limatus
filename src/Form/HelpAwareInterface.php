<?php

declare(strict_types=1);

namespace Limatus\Form;

interface HelpAwareInterface
{
    public function setHelp(string $help): self;

    public function getHelp(): string;

    public function setHelpAttribute(string $key, string $value): self;

    public function getHelpAttribute(string $key): string|null;

    public function setHelpAttributes(iterable $arrayOrTraversable): self;

    public function getHelpAttributes(): array;

    public function hasHelpAttribute(string $key): bool;

    public function removeHelpAttributes(array $keys): self;

    public function clearHelpAttributes(): self;
}
