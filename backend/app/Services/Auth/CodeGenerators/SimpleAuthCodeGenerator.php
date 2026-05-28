<?php

namespace App\Services\Auth\CodeGenerators;

class SimpleAuthCodeGenerator implements AuthCodeGenerator
{
    public function generate(): string
    {
        return rand(10000, 99999);
    }
}
