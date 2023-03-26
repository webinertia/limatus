<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\Form;
use Psr\Container\ContainerInterface;

final class FormFactory
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container): Form
    {
        return new Form();
    }
}
