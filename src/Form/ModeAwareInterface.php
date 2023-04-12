<?php

declare(strict_types=1);

namespace Bootstrap\Form;

interface ModeAwareInterface
{
    public const DEFAULT_MODE    = 'default';
    public const INLINE_MODE     = 'inline';
    public const GRID_MODE       = 'grid';
    public const HORIZONTAL_MODE = 'horizontal';

    public function getMode(): string|null;

    public function hasMode(): bool;

    public function setMode(string $mode): self;

    public function setHorizontalAttributes(array $horizontalAttributes): self;

    public function getHorizontalAttributes(): array;

    public function setHorizontalAttribute(string $key, string $value): self;
}
