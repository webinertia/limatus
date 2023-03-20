<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper;
use Laminas\EventManager\EventManager;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormRow;

use function str_contains;

class FormRowDelegator extends FormRow
{
    protected Helper\FormRow $bootstrapFormRow;
    protected array $config;
    protected FormRow $defaultFormRow;
    protected EventManager $eventManager;
    /**
     * The attributes for the row label
     *
     * @var array
     */
    protected $labelAttributes = ['always_wrap' => false];

    /**
     * @param FormRow $defaultFormRow
     * @param Helper\FormRow $bootstrapFormRow
     * @param EventManager $eventManager
     * @param array<string, mixed> $config
     * @return void
     */
    public function __construct($defaultFormRow, $bootstrapFormRow, $eventManager, array $config)
    {
        $this->defaultFormRow   = $defaultFormRow;
        $this->bootstrapFormRow = $bootstrapFormRow;
        $this->eventManager     = $eventManager;
        $this->config           = $config;
    }

    /** @inheritDoc */
    public function __invoke(
        ElementInterface $element = null,
        ?string $labelPosition = null,
        ?bool $renderErrors = null,
        ?string $partial = null
    ) {
        // phpcs:disable
        return $this->render($element, $labelPosition);
        // phpcs:enable
    }

    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
        if ($element instanceof BootstrapInterface || $this->classCheck($element)) {
            $bootstrap = $this->getBootstrapRow();
            // phpcs:disable
            return $bootstrap($element, $labelPosition);
            // phpcs:enable
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
