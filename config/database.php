<?php

function database($path = NULL){
    $_DATABASE['config'] = array(
        'mysql' => array(
            'dsn' => 'mysql:host=localhost',
            'host' => 'localhost',
            'database' => 'db_matcha',
            'username' => 'root',
            'password' => 'co65amHr'
        )
    );

    if ($path)
    {
        $config = $_DATABASE['config'];
        $path = explode('/',$path);
        foreach ($path as $bit)
        {
            if (isset($config[$bit]))
                $config = $config[$bit];
        }
        return ($config);
    }
    return (FALSE);
}

function make($string, $salt = '')
{
    return(hash('sha256', $string.$salt));
}

function salt($seasoning)
{
    return(str_shuffle($seasoning));
}

function init()
{
    $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
        $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'db_matcha'";
        $result = $pdo->query($sql)->fetchAll();
        if (empty($result))
        {
            header('Location: config/setup.php');
        }
    }catch(PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

?>
