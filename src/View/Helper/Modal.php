<?php

declare(strict_types=1);

namespace Limatus\View\Helper;

use Laminas\View\Helper;
use Limatus\View\HelperInterface;

class Modal extends Helper\AbstractHelper implements HelperInterface
{
    protected string $id;
    protected string $title;
    protected string $content;
    protected string $fx;

    public function __invoke(): self
    {
        return $this;
    }

    public function systemMessage(): string
    {
        return '
            <div
            class="modal"
            id="system-message-modal"
            tabindex="-1"
            aria-labelledby="system-message-title"
            aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="system-message-title">System Message</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div id="system-message" class="modal-body"></div>
                    </div>
                </div>
            </div>';
    }
}
