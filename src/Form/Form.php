<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\ElementPrepareAwareInterface;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form as BaseForm;

use function strtolower;

class Form extends BaseForm implements ModeAwareInterface
{
    use ElementTrait;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    public function addSubmit(?int $priority = 1, ?string $showText = 'Save', ?string $class = 'btn btn-primary'): void
    {
        $this->add(
            [
                'name'       => 'submit',
                'type'       => Submit::class,
                'attributes' => [
                    'id'    => strtolower($showText) . $this->getAttribute('name') . 'Button',
                    'value' => $showText,
                    'class' => $class,
                ],
            ],
            ['priority' => $priority],
        );
    }
        /**
     * Ensures state is ready for use
     *
     * Marshalls the input filter, to ensure validation error messages are
     * available, and prepares any elements and/or fieldsets that require
     * preparation.
     *
     * @return $this
     */
    public function prepare()
    {
        if ($this->isPrepared) {
            return $this;
        }

        $this->getInputFilter();

        // If the user wants to, elements names can be wrapped by the form's name
        if ($this->wrapElements()) {
            $this->prepareElement($this);
        } else {
            foreach ($this->getIterator() as $elementOrFieldset) {
                // insure all fieldsets and elements are in the same mode
                if ($elementOrFieldset instanceof ModeAwareInterface) {
                    $elementOrFieldset->setMode($this->getMode());
                }
                if ($elementOrFieldset instanceof Form) {
                    $elementOrFieldset->prepare();
                } elseif ($elementOrFieldset instanceof ElementPrepareAwareInterface) {
                    $elementOrFieldset->prepareElement($this);
                }
            }
        }

        $this->isPrepared = true;
        return $this;
    }
}
