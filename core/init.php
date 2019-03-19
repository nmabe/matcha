<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:27 PM
 */

require_once 'functions/sanitize.php';

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'dsn' => 'mysql:host=localhost;',
        'host' => 'localhost',
        'database' => 'db_matcha',
        'username' => 'root',
        'password' => 'co65amHr'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_exp' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
    'cities' => array(
        'LatitudeJhb' => '-26.195246',
        'LongitudeJhb' => ' 28.034088',
        'LatitudeDbn' => '-29.8579006',
        'LongitudeDbn' => '31.0291996',
        'LatitudePta' => '-25.731340',
        'LongitudePta' => '28.218370',
        'LatitudeCpt' => '-33.918861',
        'LongitudeCpt' => '18.423300',
        'LatitudePlk' => '',
        'LongitudePlk' => '',
        'LatitudePE' => '',
        'LongitudePE' => '',
        'LatitudeRtn' => '',
        'LongitudeRtn' => '',
        'LatitudeNsp' => '',
        'LongitudeNsp' => '',
        'LatitudeBlm' => '',
        'LongitudeBlm' => '',
        'Latitude' => '',
        'Longitude' => ''
    )
);

spl_autoload_register(function ($class){
    require_once 'class/' . $class . '.php';
});


if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
{
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));
    if ($hashCheck->count())
    {
        $user = new User($hashCheck->first()->user_id);
        $user->login;
    }
}