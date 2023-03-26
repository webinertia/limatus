<?php

declare(strict_types=1);

namespace Bootstrap;

interface BootstrapInterface
{
    public const VIEW_HELPER_CONFIG_KEY = 'bootstrap';
    public const MODE_DEFAULT           = 'default';
    public const MODE_INLINE            = 'inline';
    public const MODE_GRID              = 'grid';
    public const OPENING_KEY            = 'opening';
    public const SEPARATOR_KEY          = 'separator';
    public const CLOSING_KEY            = 'closing';
}
