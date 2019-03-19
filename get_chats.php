<?php
    require_once 'core/init.php';

    $user = New User();

    if ($user)
    {
        $fromUser = $user->data()->id;
        $toUser = Input::get('to_user_id');
        $chats = DB::getInstance()->query("
        SELECT * 
        FROM `chats` 
        WHERE `toID` =  $toUser AND  `fromID` = $fromUser
        OR `toID` = $fromUser AND `fromID` = $toUser
        ORDER BY `sendDate` DESC", array());
        $output = '<ul class="list-unstyle">';
        
        if ($chats->count())
        {
            foreach ($chats->result() as $row)
            {
                $user_name = '';
                $message = '';
                $m_time = '';
                foreach($row as $item => $rows)
                {
                    if ($row->fromID == $fromUser)
                    {
                        $user_name = '<b class="text-success">You</b>';
                    }else{
                        $recipient = DB::getInstance()->get('users', array('id', '=', $toUser));
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

        echo $output;
    }
    
?>