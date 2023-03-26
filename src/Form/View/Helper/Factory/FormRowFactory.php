<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\FormRow;
use Psr\Container\ContainerInterface;

final class FormRowFactory
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container): FormRow
    {
        return new FormRow();
    }
}
