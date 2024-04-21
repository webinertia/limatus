<?php

declare(strict_types=1);

namespace Limatus\Provider\Bootstrap;

enum LayoutMode: string
{
    case Default    = 'default';
    case Grid       = 'grid';
    case Horizontal = 'horizontal';
    case Inline     = 'inline';
}
