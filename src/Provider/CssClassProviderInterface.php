<?php

declare(strict_types=1);

namespace Limatus\Provider;

interface CssClassProviderInterface
{
    public function getClass(): string;
}
