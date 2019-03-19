<?php

    require_once 'core/init.php';
    $user = new User();

    if (Input::exists())
    {
        $provID = $user->data()->id;
        $requester = $user->data()->username;
        $reqID = Input::get('request');
        $to = new User($reqID);
        $provider = $to->data()->username;
        $newNotif = array();
        $checkReq = DB::getInstance()->query("SELECT * FROM `mates` WHERE `reqID` = {$reqID} AND `provID` = {$provID}");
        if ($checkReq->count())
        {
            try{
                DB::getInstance()->update('mates', $checkReq->first()->id, array(
                    'accepted' => 1
                ));
            }catch(PDOException $e){
                throw new PDOException($e->getMessage);
            }
            if ($to)
            {
                $user_id = $to->data()->id;
                $newNotification = 'Your Request Has been Accepted';
                $ref = "user.php?reqID=$reqID&provID=$provID";
                $dt = new DateTime("now", new DateTimeZone('Africa/Johannesburg'));     // first argument "must" be a string
                $dt->setTimestamp(time());                                             // adjust the object to correct timestamp
                try{
                        DB::getInstance()->insert('notifications', array(
                            'id' => NULL,
                            'user_id' => $user_id,
                            'notifier_id' => $user->data()->id,
                            'name' => $user->data()->username,
                            'avatar' => $user->data()->avatar,
                            'notification' => $newNotification
                          ));
                    $mail = new Mail($reqID);
                // $mail->sendRequest($provId, $requestId);
                }catch(PDOException $e){
                    throw new PDOException($e->getMessage());
                }
            }
        }
        else{
                echo "<p>ERROR: Something Went Wrong Please Try Again ...</p>";
        }
        }
?>