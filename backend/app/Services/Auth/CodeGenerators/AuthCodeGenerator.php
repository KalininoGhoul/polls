<?php

namespace App\Services\Auth\CodeGenerators;

interface AuthCodeGenerator
{
    public function generate(): string;
}
