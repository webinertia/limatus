<?php

declare(strict_types=1);

namespace Limatus\Form;

use Laminas\Form\ElementPrepareAwareInterface;
use Laminas\Form\Fieldset as BaseFieldset;
use Laminas\Form\FormInterface;

class Fieldset extends BaseFieldset implements
    ElementInterface,
    ModeAwareInterface
{
    use ElementTrait;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function prepareElement(FormInterface $form): void
    {
        $name = $this->getName();

        foreach ($this->iterator as $elementOrFieldset) {
            $elementOrFieldset->setName($name . '[' . $elementOrFieldset->getName() . ']');

            if ($elementOrFieldset instanceof ModeAwareInterface) {
                $elementOrFieldset->setMode($this->getMode());
            }

            // Recursively prepare elements
            if ($elementOrFieldset instanceof ElementPrepareAwareInterface) {
                if ($elementOrFieldset instanceof ModeAwareInterface) {
                    $elementOrFieldset->setMode($this->getMode());
                }
                $elementOrFieldset->prepareElement($form);
            }
        }
    }
}
