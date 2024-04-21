<?php

declare(strict_types=1);

namespace Limatus\Provider\Bootstrap;

use Limatus\Provider\CssClassProviderInterface;
use Limatus\Provider\CssClassProviderTrait;

enum ElementClass: string implements CssClassProviderInterface
{
    use CssClassProviderTrait;

    case Select        = 'select';
    case Text          = 'text';
    case Button        = 'button';
    case Checkbox      = 'checkbox';
    case File          = 'file';
    case Image         = 'image';
    case Password      = 'password';
    case Radio         = 'radio';
    case Reset         = 'reset';
    case Submit        = 'submit';
    case Date          = 'date';
    case Datetime      = 'datetime';
    case DatetimeLocal = 'datetime-local';
    case Email         = 'email';
    case Month         = 'month';
    case Number        = 'number';
    case Range         = 'range';
    case Search        = 'search';
    case Tel           = 'tel';
    case Time          = 'time';
    case Url           = 'url';
    case Week          = 'week';
    case Textarea      = 'textarea';
}
