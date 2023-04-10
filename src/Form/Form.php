<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Element\Submit;
use Laminas\Form\Form as BaseForm;

use function strtolower;

class Form extends BaseForm
{
    public function addSubmit(?int $priority = 1, ?string $showText = 'Save'): void
    {
        $this->add(
            [
                'name'       => 'submit',
                'type'       => Submit::class,
                'attributes' => [
                    'value' => $showText,
                    'id'    => strtolower($showText) . $this->getAttribute('name') . 'Button',
                ],
            ],
            ['priority' => $priority],
        );
    }
}
