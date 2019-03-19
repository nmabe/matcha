<?php

    require_once 'core/init.php';
    $user = new User();

    if (Input::exists())
    {
        $requestId = $user->data()->id;
        $requester = $user->data()->username;
        $provId = Input::get('request');

       // die("ProvID {$provId}<br>ReqID[$requestId]<br>");
        DB::getInstance()->insert('mates', array(
            'reqID' => $requestId,
            'provID' => $provId,
            'accepted' => 0 
        ));
     
        $to = new User($provId);
        if ($to)
        {
            $notifications = $to->data()->notifications;
            $newNotification = 'You Have a New Mate Request';
            $ref = "user.php?reqID=$requestId&provID=$provId";
            $dt = new DateTime("now", new DateTimeZone('Africa/Johannesburg'));     // first argument "must" be a string
            $dt->setTimestamp(time());                                              // adjust the object to correct timestamp
            try{
                $user_id = $to->data()->id;
                DB::getInstance()->insert('notifications', array(
                    'id' => NULL,
                    'user_id' => $user_id,
                    'notifier_id' => $user->data()->id,
                    'name' => $user->data()->username,
                    'avatar' => $user->data()->avatar,
                    'notification' => $newNotification
                  ));
                $mail = new Mail($requestId);
               // $mail->sendRequest($provId, $requestId);
            }catch(PDOException $e){
                throw new PDOException($e->getMessage());
            }
        }
    }
?>