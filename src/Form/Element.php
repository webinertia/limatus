<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Element as LaminasElement;

class Element extends LaminasElement
{
    /**
     * @param  null|int|string   $name    Optional name for the element
     * @param  iterable $options Optional options for the element
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($name = null, iterable $options = [])
    {
        if (null !== $name) {
            $this->setName((string) $name);
            $this->setAttribute('id', $name);
        }

        if (! empty($options)) {
            $this->setOptions($options);
        }
    }
}
