<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:25 PM
 */

class Config
{
    public static function get($path = null)
    {
        $config = $GLOBALS['config'];
        if ($path)
        {
            $path = explode('/', $path);
            foreach ($path as $bit)
            {
                if (isset($config[$bit]))
                    $config = $config[$bit];
            }
            return ($config);
        }
        return (false);
    }
}