<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\View\Helper\Bootstrapper;

use function method_exists;

trait FormHelperTrait
{
    protected ?Bootstrapper $bootstrap;
    /** Rendering mode for Bootstrap */
    protected ?string $mode;

    protected function getBootstrapper(): Bootstrapper
    {
        if ($this->view !== null && method_exists($this->view, 'plugin')) {
            $this->bootstrap = $this->view->plugin('bootstrap');
        }
        return $this->bootstrap;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}
