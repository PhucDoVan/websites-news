<?php

namespace App\Http\Helpers;

class GenerateHelper
{
    /**
     * Random string
     *
     * @param $length
     * @param $pattern
     * @return string
     */
    public static function randomString($length, $pattern)
    {
        $charactersLength = strlen($pattern);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $pattern[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Generate username & uid
     *
     * @param $length
     * @return string
     */
    public static function generateLoginId($length)
    {
        $characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        return self::randomString($length, $characters);
    }

    /**
     * Generate password
     *
     * @param $length
     * @return string
     */
    public static function generatePassword($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_!@#$%^&*.';
        return self::randomString($length, $characters);
    }
}
