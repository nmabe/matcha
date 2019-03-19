<?php
  require_once 'core/init.php';
  date_default_timezone_set('Africa/Johannesburg');

  $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);

  $user = new User();

  if ($user)
  {
    $date_t = new DateTime("now", new DateTimeZone('Africa/Johannesburg'));     // first argument "must" be a string
    $date_t->setTimestamp(time());
    DB::getInstance()->update('user_session', $user->data()->id , array(
      'last_seen' => $date_t->format("Y-m-d h:i:s")
    ), 'user_id');
    $people = DB::getInstance()->get('users', array('id', '<>', $user->data()->id)); 

  }

  $output = '
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                            <div class="srch_bar">
                                <div class="stylish-input-group">
                                    <input type="text" class="search-bar"  placeholder="Search" >
                                    <span class="input-group-addon">
                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                    </span> </div>
                            </div>
                        </div>
                        <div class="inbox_chat">';

                        

                            foreach ($people->result() as $item)
                            {

                                $idUser = $item->id;
                                $recip = DB::getInstance();
                                $recip->query("SELECT * FROM mates WHERE (reqID = {$user->data()->id} AND provID = {$idUser}) OR (reqID = {$idUser} AND provID = {$user->data()->id})", array());

                                if ($recip->count() && $recip->first()->accepted == 1)
                                {
                                    $status = '';
                                    $loginDetails = DB::getInstance()->get('user_session', array('user_id', '=', $item->id));
                                    if ($loginDetails->count())
                                    {
                                      if ($current_timestamp < $loginDetails->first()->last_seen)
                                      {
                                        $status = '<i class="fa fa-circle" style="font-size:18px;color:red;top:2px;left:2px;"></i>';
                                      }else{
                                        $status = '<i  class="fa fa-circle" style="font-size:18px;color:green"></i>';
                                      }
                                    }else{
                                        $status = '<i  class="fa fa-circle" style="font-size:18px;color:red"></i>';
                                    }
  $output .=                                '
                                    <button type="button" class="btn btn-primary start_chat" data-touserid="'.$item->id.'" data-tousername="'.$item->username.'">
                                    <div class="chat_list ">
                                    <div style="top:-2px;left:82px;position: relative;">'. $status .' </div>
                                    <div class="chat_people">
                                        <div class="chat_img"> <img src=" ' .$item->avatar .' " alt="sunil"> </div>
                                        <div class="chat_ib">
                                                <h5>'.$item->fullname .'<span class="chat_date">Dec 25</span></h5>
                                                <p>Test, which is a new approach to have all solutions
                                                    astrology under one roof.</p>
                                            </div>
                                        </div>
                                    </div>
                                    </button>';
                                }
                              }

$output .=                  '</div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history">

                            
                            
                        </div>
                    </div>';

echo $output;

?>
