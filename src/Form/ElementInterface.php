<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\ElementInterface as BaseInterface;

interface ElementInterface extends BaseInterface
{
    public function setBootstrapAttribute(string $key, string|bool $value): self;

    public function getBootstrapAttribute(string $key): string|null;

    public function setBootstrapAttributes(iterable $arrayOrTraversable): self;

    public function getBootstrapAttributes(): array;

    public function removeBootstrapAttribute(string $key): self;

    public function removeBootstrapAttributes(array $keys): self;

    public function hasBootstrapAttribute(string $key): bool;
}
