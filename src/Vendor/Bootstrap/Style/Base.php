<?php

declare(strict_types=1);

namespace Limatus\Vendor\Bootstrap\Style;

enum Base: string
{
    case FormControl    = 'form-control';
    case FormFile       = 'form-control-file';
    case FormSelect     = 'form-select';
    case FormCheckInput = 'form-check-input';
    case FormCheckLabel = Label::FormCheck->value;
    case Btn            = 'btn';
    case TextNoWrap     = 'text-nowrap';
}
