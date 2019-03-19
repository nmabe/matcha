<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:27 PM
 */

class Input
{
    public static function exists($type = 'post')
    {
        switch ($type)
        {
            case 'post':
                return (!empty($_POST) ? true : false);
             break;
            case 'get':
                return (!empty($_GET) ? true : false);
            break;
            default;
                return (false);
             break;
        }
    }

    public  static function get($item)
    {
        if (isset($_POST[$item])) {
            return (escape($_POST[$item]));
        }
        else if (isset($_GET[$item])) {
            return (escape($_GET[$item]));
        }
        return ('');
    }
}