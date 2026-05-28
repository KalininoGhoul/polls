<?php

namespace App\Enums\Auth;

enum AuthCodeType: string
{
    case TEST = 'test';

    case MAIL = 'mail';
}
