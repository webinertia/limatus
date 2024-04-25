<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap;

trait CssClassVendorTrait
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
            self::Textarea => Style\Base::FormControl->value,
            self::Button,
            self::Reset,
            self::Submit   => Style\Base::Btn->value,
            self::Checkbox,
            self::Radio    => Style\Base::FormCheckInput->value,
            self::File     => Style\Base::FormFile->value,
        };
    }
}
