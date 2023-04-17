<?php

declare(strict_types=1);

namespace Limatus\Form;

use Laminas\Form\Element as BaseElement;
use Limatus\Form\HelpAwareInterface;
use Limatus\Form\ModeAwareInterface;

class Element extends BaseElement implements
    ElementInterface,
    HelpAwareInterface,
    ModeAwareInterface
{
    use ElementTrait;
}
