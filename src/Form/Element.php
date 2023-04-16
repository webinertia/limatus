<?php

declare(strict_types=1);

namespace Limatus\Form;

use Limatus\Form\HelpAwareInterface;
use Limatus\Form\ModeAwareInterface;
use Laminas\Form\Element as BaseElement;

class Element extends BaseElement implements
    ElementInterface,
    HelpAwareInterface,
    ModeAwareInterface
{
    use ElementTrait;
}
