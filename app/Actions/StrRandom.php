<?php

namespace App\Actions;

class StrRandom
{
    public function get($length)
    {
        return \Str::random($length);
    }
}
