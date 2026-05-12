<?php

namespace App\Http\Controllers;

class TestController
{
    public function test()
    {
        $q = 5;
        $b = 4;

        $w = $q - $b;

        return $w;
    }
}
