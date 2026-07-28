<?php

namespace Theme\Helpers;

class ContactObfuscation
{
    public static function encode(string $value): string
    {
        return base64_encode($value);
    }
}
