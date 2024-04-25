<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap\Style;

enum Color: string
{
    case Primary   = 'primary';
    case Secondary = 'secondary';
    case Success   = 'success';
    case Danger    = 'danger';
    case Warning   = 'warning';
    case Info      = 'info';
    case Light     = 'light';
    case Dark      = 'dark';

    public function btnColor(Base $btn)
    {
        return match($this) {
            self::Primary,
            self::Secondary,
            self::Success,
            self::Danger,
            self::Warning,
            self::Info,
            self::Light,
            self::Dark => $btn->value . '-' . $this->value,
            default    => $btn->value . '-' . $this->value,
        };
    }
}
