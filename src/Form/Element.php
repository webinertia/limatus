<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Bootstrap\Form\HelpAwareInterface;
use Bootstrap\Form\ModeAwareInterface;
use Laminas\Form\Element as BaseElement;

class Element extends BaseElement implements
    ElementInterface,
    HelpAwareInterface,
    ModeAwareInterface
{
    use ElementTrait;
}
