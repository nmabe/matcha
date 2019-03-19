<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:25 PM
 */

class Cookie
{
    public  static function exists($name)
    {
        return (isset($_COOKIE[$name]) ? true : false);
    }

    public  static function delete($name)
    {
        self::set($name, '', time() -1);
    }

    public static function set($name, $value, $exp = null)
    {
        setcookie($name, $value, $exp, '/');
    }

    public static function get($name)
    {
        return($_COOKIE[$name]);
    }
}