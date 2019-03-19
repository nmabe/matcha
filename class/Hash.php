<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 11:39 PM
 */

class Hash
{
    public static function make($password, $salt = null)
    {
        return (hash('sha256', $password.$salt));
    }

    public static function salt()
    {
        $seasoning = "s!0@a#8$%6l^&t5*(i))(*n2&^%g$#@!";
        return(str_shuffle($seasoning));
    }

    public static function unique()
    {
        return(self::make(uniqid()));
    }
}

