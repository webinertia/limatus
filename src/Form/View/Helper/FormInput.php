<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper;

class FormInput extends AbstractHelper
{
    public function __construct(protected Helper\FormInput $helper)
    {
    }

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @template T as null|ElementInterface
     * @psalm-param T $element
     * @psalm-return (T is null ? self : string)
     * @return string|FormInput
     */
    public function __invoke(?ElementInterface $element = null, ?string $mode = self::DEFAULT_MODE)
    {
        if (! $element) {
            return $this;
        }
        return $this->render($element, $mode);
    }

    /**
     * Force an id, if possible and use the original service to do its work
     */
    public function render(ElementInterface $element, ?string $mode = self::DEFAULT_MODE): string
    {
        // all we do here is force an id to prevent the input from being wrapped inside the label, we never want that
        $this->helper->setView($this->view);
        if ($element->getName() && ! $element->hasAttribute('id')) {
            $element->setAttribute('id', $element->getName());
        }

        return $this->helper->render($element);
    }
}
