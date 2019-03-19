<?php

    require_once 'core/init.php';
    
    $id = Input::get('user');

    $user = new User($id);

    if (Input::exists())
    {
        $requestId = Input::get('request');
        $provId = $user->data()->id;

        try{
            $check = DB::getInstance();
            $check->query("DELETE FROM mates WHERE (reqID = {$requestId} AND provID = {$provId}) OR (reqID = {$provId} AND provID = {$requestId})", array());
            echo "<p>User is No longer Your Mate</p>";
        }catch(PDOException $e)
        {
            echo($e->getMessage());
        }

        try{
            $newNotification = 'Your Connection Has been Removed';
            DB::getInstance()->insert('notifications', array(
                'id' => NULL,
                'user_id' => $requestId,
                'notifier_id' => $user->data()->id,
                'name' => $user->data()->username,
                'avatar' => $user->data()->avatar,
                'notification' => $newNotification
              ));
        }catch(PDOException $e){
            echo($e->getMessage());
        }
        $mail = new Mail($provId);
        //$mail->sendRequest($requestId, $provId);
    }
    ?>
