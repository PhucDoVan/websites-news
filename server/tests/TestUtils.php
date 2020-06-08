<?php

namespace Tests;

trait TestUtils
{
    /**
     * Generate a string number with length of digits
     *
     * @param int $length
     * @return string
     */
    public function generateRandomNumber($length = 10)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '1';
        for ($i = 1; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Generate a string with length of characters
     *
     * @param int $length
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}