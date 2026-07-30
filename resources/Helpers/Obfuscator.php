<?php

namespace Theme\Helpers;

class Obfuscator
{
    public static function encode(string $value): string
    {
        return base64_encode($value);
    }
}
