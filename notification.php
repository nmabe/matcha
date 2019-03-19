<?php
  
    require_once 'core/init.php';

    $id = Input::get('id');

    if ($id)
    {
        DB::getInstance()->delete('notifications', array('id', '=', $id));
    }else{
        echo("Error: Notification: '.$id.' Not Found!");
    }
?>