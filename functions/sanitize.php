<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:28 PM
 */

function escape($string)
{
    return (htmlentities($string, ENT_QUOTES, 'utf-8'));
}