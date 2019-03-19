<?php
    require_once 'core/init.php';

    $user = new User();

    if ($user)
    {
        $to_user = Input::get('to_user_id');
        $from_user = $user->data()->id;
        $message = Input::get('chat_message');
        $message_save = DB::getInstance()->insert('chats', array(
            'toID' => $to_user,
            'fromID' => $from_user,
            'message' => $message,
            'status' => 1
        ));
        $dt = new DateTime("now", new DateTimeZone('Africa/Johannesburg'));     // first argument "must" be a string
        $dt->setTimestamp(time());  
        
        if ($message_save)
        {
            $result = DB::getInstance()->query("
            SELECT * 
            FROM `chats` 
            WHERE `toID` =  $to_user AND  `fromID` = $from_user
            OR `toID` = $from_user AND `fromID` = $to_user
            ORDER BY `sendDate` DESC", array());
        }
        
        $output = '<ul class="list-unstyle">';
        
        if ($result->count())
        {
            $chat = array();
            foreach ($result->result() as $key => $row)
            {
                $user_name = '';
                $message = '';
                $m_time = '';
                foreach($row as $item => $rows)
                {
                    if ($row->fromID == $from_user)
                    {
                        $user_name = '<b class="text-success">You</b>';
                    }else{
                        $recipient = DB::getInstance()->get('users', array('id', '=', $to_user));
                        $user_name = $recipient->first()->username;
                        $user_name = "<b class=\"text-success\">{$user_name}</b>";
                    }

                    $message = $row->message;
                    $m_time == $row->sendDate;
                }

                    
                    $output .= '
                    <li style="border-bottom:1px dotted #ccc">
                    <p>'. $user_name .' - '. $message .'
                    <div align="right">
                    - <small><em> '. $row->sendDate .' </em></small>
                    </div>
                    </p>
                    </li>
                    ';
            }
        }
        $output .= '</ul>';

        $recipient = DB::getInstance()->get('users', array('id', '=', $to_user));
        $user_name = $recipient->first()->username;
        $notice = $recipient->first()->notifications;
        $requester = $user->data()->fullname;
        $ref = "user.php?provID=$from_user";
        $newNotification = "You Have a new Message";
        if (empty($notice))
        {
            $notifications = array();
            $notifications[] = array(
                'time' => $dt->format('d-m-Y H:i:s'),
                'notification' => $newNotification,
                'ref' => $ref,
                'sender' => $requester
            );
            $notifications = serialize($notifications);
        }else{
            $notifications = unserialize($notice);
            $notifications[] = array(
            'time' => $dt->format('d-m-Y H:i:s'),
            'notification' => $newNotification,
            'ref' => $ref,
            'sender' => $requester
            );
            $notifications = serialize($notifications);
        }
        $field = array(
            'notifications' => $notifications
        );
        $user_name = "<b class=\"text-success\">{$user_name}</b>";

        try{

            DB::getInstance()->update('users', $to_user, $field);
            echo $output;
            
        $message = "{$requester} Has Sent You a Message ...";
          
          DB::getInstance()->insert('notifications', array(
            'id' => NULL,
            'user_id' => $to_user,
            'notifier_id' => $user->data()->id,
            'name' => $user->data()->username,
            'avatar' => $user->data()->avatar,
            'notification' => $message
          ));
        }catch(PDOException $e){
            throw new PDOException($e-getMessage());
        };
    }

?>