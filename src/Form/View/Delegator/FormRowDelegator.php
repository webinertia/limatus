<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormRow;

use function explode;
use function str_contains;

class FormRowDelegator extends FormRow
{

    protected Helper\FormRow $bootstrapFormRow;
    protected array $config;
    protected $defaultFormRow;
    protected $eventManager;
    /**
     * The attributes for the row label
     *
     * @var array
     */
    protected $labelAttributes = ['always_wrap' => false];

    public function __construct($defaultFormRow, $bootstrapFormRow, $eventManager, array $config)
    {
        $this->defaultFormRow   = $defaultFormRow;
        $this->bootstrapFormRow = $bootstrapFormRow;
        $this->eventManager     = $eventManager;
        $this->config           = $config;
    }

    public function __invoke(
        $element = null,
        ?string $labelPosition = null,
        ?bool $renderErrors = null,
        ?string $partial = null
    ) {
        return $this->render($element, $labelPosition); // phpcs:ignore
    }

    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
        if ($element instanceof BootstrapInterface || $this->classCheck($element)) {
            $bootstrap = $this->getBootstrapRow();
            return $bootstrap($element, $labelPosition);
        }
        return parent::render($element, $labelPosition);
    }

    protected function classCheck(ElementInterface $element): bool
    {
        $classString      = $element->getAttribute('class');
        $supportedClasses = $this->config['attributes']['supported_classes'];
        for ($i=0; $i < count($supportedClasses); $i++) {
            if (str_contains($classString, $supportedClasses[$i])) {
                return true;
            }
        }
        return false;
    }

    public function getBootstrapRow(): Helper\FormRow
    {
        return $this->bootstrapFormRow;
    }
}
