<?php

    require_once 'core/init.php';
    $user = new User();

    if (Input::exists())
    {
        $reqID = $user->data()->id;
        $requester = $user->data()->username;
        $provID = Input::get('request');
        $notifications = $user->data()->notifications;
        $to = new User($reqID);
        if ($to)
        {
            $provider = $to->data()->username;
            $newNotification = 'Your Request Was Cancelled';
            try{
                DB::getInstance()->insert('notifications', array(
                    'id' => NULL,
                    'user_id' => $user->data()->id,
                    'notifier_id' => $to->data()->id,
                    'name' => $user->data()->username,
                    'avatar' => $user->data()->avatar,
                    'notification' => $newNotification
                ));
            }catch(PDOException $e)
            {
                throw new PDOException($e->getMessage());
            }
        }
        $checkReq = DB::getInstance()->query("SELECT * FROM `mates` WHERE `reqID` = {$reqID} AND `provID` = {$provID}");
        if ($checkReq->count())
        {
            try{
                //                DB::getInstance()->query("SELECT * FROM `mates` WHERE `reqID` = {$reqID} AND `provID` = {$provID}");
                DB::getInstance()->delete('mates', array('id', '=', $checkReq->first()->id));
            }catch(PDOException $e){
                throw new PDOException($e->getMessage);
            }
        }
        else{
                echo "<p>ERROR: Something Went Wrong Please Try Again ...</p>";
        }
        }
?>