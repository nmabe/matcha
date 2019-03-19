<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:26 PM
 */

class Session
{
    public  static function set($name, $value)
    {
        return($_SESSION[$name] = $value);
    }

    public static function delete($name)
    {
        if (self::exists($name))
        {
            unset($_SESSION[$name]);
        }
    }

    public static function exists($name)
    {
        return (isset($_SESSION[$name]) ? true : false);
    }

    public static function get($name)
    {
        return ($_SESSION[$name]);
    }

    public static function flash($name, $string = '')
    {
        if (self::exists($name))
        {
            $session = $_SESSION[$name];
            self::delete($name);
            return ($session);
        }
        else{
            self::set($name, $string);
        }
    }
}