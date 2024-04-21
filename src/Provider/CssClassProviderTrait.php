<?php

declare(strict_types=1);

namespace Limatus\Provider;

trait CssClassProviderTrait
{
    public function getClass(): string
    {
        return match($this) {
            self::Select,
            self::Text,
            self::Image,
            self::Password,
            self::Date,
            self::Datetime,
            self::DatetimeLocal,
            self::Email,
            self::Month,
            self::Number,
            self::Range,
            self::Search,
            self::Tel,
            self::Time,
            self::Url,
            self::Week,
            self::Textarea => 'form-control',
            self::Button,
            self::Reset,
            self::Submit   => 'btn',
            self::Checkbox,
            self::Radio    => 'form-check-input',
            self::File     => 'form-control-file',
        };
    }
}
