<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\ElementInterface;

use function sprintf;

class FormHelp extends AbstractHelper
{
    protected static $helpElement = '<small %s>%s</small>';
    protected static $helpString = 'Help';

    public function __invoke(): self
    {
        return $this;
    }

    public function render(?ElementInterface $element): string
    {
        $markup = '';
        if ($element->getHelp() !== null) {
            if ($element->hasAttribute('aria-describedby')) {
                $element->setHelpAttribute('id', $element->getAttribute('aria-describedby'));
            } elseif ($element->hasAttribute('id')) {
                // They forgot to set this, but we have to have one that ties the two elements together so build one
                $id = $element->getAttribute('id');
                $describedBy = $id . self::$helpString;
                $element->setAttribute('aria-describedby', $describedBy);
                $element->setHelpAttribute('id', $describedBy);
            }

            $markup = sprintf(
                self::$helpElement,
                $this->createAttributesString($element->getHelpAttributes()),
                $element->getHelp()
            );
        }
        return $markup;
    }
}
