<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\FormCollection;
use Psr\Container\ContainerInterface;

final class FormCollectionFactory
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container): FormCollection
    {
        return new FormCollection();
    }
}
