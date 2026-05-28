<?php

namespace App\Services\Auth\CodeGenerators;

class TestAuthCodeGenerator implements AuthCodeGenerator
{
    public function generate(): string
    {
        return "12345";
    }
}
