<?php
  require_once 'core/init.php';

  $user = new User();

  if (Input::exists())
  {
      if (Input::get('sender') && Input::get('recipient'))
      {
          echo("Input sender is: ".Input::get('recipient'));
      }
  }

  if ($user->isLoggedIn())
  {
    $notifications = DB::getInstance()->get('notifications', array('user_id', '=', $user->data()->id));
      $numOfNotifications = 0;
      if ($notifications->count())
      {
        foreach($notifications->result() as $thesis)
        {
            $numOfNotifications++;
        }
      }
  }else{
    Redirect::to('index.php');
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Chats</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
  </style>
</head>
<body>
<div class="bg">
  
  <div class="jumbotron-fluid text-left" style="margin-bottom:0;">
      <a style="text-decoration: none; color:#f1f1f1;font-family: 'Kumar One Outline', cursive;" href="index.php"><h1>Matcha 💖</h1>
      <p>Find Your Match</p></a>
  </div>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="color:white; opacity:0.5; filter: alpha(opacity=30);">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="document.getElementById('id03').style.display='block'">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="match.php">Find Match</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">My Chats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>    
      </ul>
    </div>
    <?php
    if ($user->isLoggedIn())
        {
    ?>
    <div class="dropdown">
      <a class="dropbtn" href="#" id="navbarDropdown" role="button" onclick="notifDropDown()">
        <i class="fa fa-bell-o fa-3x" aria-hidden="true"></i></a><span style="font-weight: bold; font-size: 17px;">Notifications</span>
        <?php echo ($numOfNotifications > 0) ? "<div class=\"circle\"><p>$numOfNotifications</p></div></a>" : ':-)'; ?>
        <div id="notifis" class="dropdown-content">
          <div class="container mt-5 mb-5">
            <div class="col-md-6 offset-md-3">
              <h3>Notifications</h3>
              <ul class="timeline">
                
                    <?php
                    if ($notifications->count())
                    {
                      $i = 0;
                      foreach ($notifications->result() as $notify)
                      {
                        if ($i == 5)
                          break;
                        echo "<button type=\"button\" id=\"notifbtn_$notify->id\"class=\"btn btn-primary btn-lg\" data-options=\"'{\"id\":$notify->id}'\" onclick=\"notified($notify->id)\">
                        <div class=\"chat_people\">
                            <div style=\"border-radius:50%\" class=\"chat_img\"> <img src=\"$notify->avatar\" alt=\"sunil\"> </div>
                            <div class=\"chat_ib\">
                                    <h5 style=\"color:whitesmoke\"><span class=\"chat_date\">$notify->date</span>$notify->name</h5>
                                    <p style=\"color:whitesmoke\"><small>$notify->notification<small></p>
                                </div>
                            </div>
                        </button>";
                        $i++;
                      }
                    }
                    ?>
              </ul>
            </div>
          </div>
            <div class="footer bg-dark text-center">
              <a href="" class="text-light">View All</a>
            </div>
         </div>
    </div>
    <?php
        }
    ?>
  </nav>
        <!--
        Logout Modal
      -->
  <div id="notifis"></div>
    <div id="id03" class="modal">
      <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
      <form class="modal-content" action="logout.php" method="post">
          <div class="container">
            <h1 style="text-align:center">Log out</h1>
            <h3 style="text-align:center">Are You Sure You Want to Log out ?</h3>
            <hr>
            <div class="clearfix">
                <input name="token" type="hidden" value="<?php echo $token ?>">
                <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Nope</button>
                <button type="submit" class="signupbtn">Yep</button>
            </div>
          </div>
      </form>
    <script>
      var modal = document.getElementById('id03');

      window.onclick = function(event)
      {
        if (event.target == modal){
          modal.style.display = 'none';
        }
      }
    </script>
    </div>
  
    <div class="container">
        <div class="row">
        <div class="col-sm-4">
            <h3>My Profile</h3>
                <p>View Your Profile Here</p>
                <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="chats.php">My Chats</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="mymatch.php">My Match</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php if($user->data()->active == 0){ echo "disabled";} ?>" href="editprofile.php">Edit Profile</a>
                </li>
              </ul>
              <hr class="d-sm-none">
            </div>
            <div class="col-sm-8">
              <h3 class=" text-center">Messaging</h3>
              <div class="messaging"></div>
            </div>
          </div>
          
          <script src="js/main.js"> </script>
          <div class="jumbotron text-center" style="margin-bottom:0">
    <p>&copy Matcha Project By <small><i>nmabe</small></p>    
  </div>
</div>
</body>
</html>
<script>
  $(document).ready(function(){
    
    fetch_chatbox();
    
    setInterval(function(){
      
      fetch_chatbox();
    }, 5000);

      get_chats();
      update_chats();
    
    function fetch_chatbox() {
      $.ajax({
        url: "check.php",
        method: "POST",
        success: function(data){
          $('.messaging').html(data);
        }
      })
    }
    
    function   dialog_box(to_user_id, to_user_username)
    {
      var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You Have Chat With '+to_user_username+'" style="z-index:931;">';
      modal_content += '<div style="height:400px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding: 16px; class="chat_history" data-touserid'+to_user_id+'" id="chat_history_'+to_user_id+'" >';
      modal_content += get_chats(to_user_id);
      modal_content += '</div>';
      modal_content += '<div class="form-group">';
      modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
      modal_content += '</div><div class="form-group" alight="right">';
      modal_content += '<button type="button" name="send_chat_'+to_user_id+'" id="'+to_user_id+'" class="btn btn-info send_chat" >Send</button></div></div>';
      $('.mesgs').html(modal_content);
    }
    
    
    $(document).on('click', '.start_chat', function(){
      var to_user_id = $(this).data('touserid');
      var to_user_username = $(this).data('tousername');  
      dialog_box(to_user_id, to_user_username);
      $('#user_dialog_'+to_user_id).dialog({
        autoOpen: false,
        width: 400
      });
      $('#user_dialog_'+to_user_id).dialog('open');
    });
    
    $(document).on('click', '.send_chat', function(){
      var to_user_id = $(this).attr('id');
      var chat_message = $('#chat_message_'+to_user_id).val();
      
      console.log(chat_message);
      $.ajax({
        url:"chat.php",
        method:"POST",
        data:{to_user_id:to_user_id, chat_message:chat_message},
        success:function(data)
        {
          $('#chat_message_'+to_user_id).val('');
          $('#chat_history_'+to_user_id).html(data);
        }
      })
    });
    
    function get_chats(to_user_id)
    {
      $.ajax({
        url: 'get_chats.php',
        method: 'POST',
        data: {to_user_id:to_user_id},
        success: function(data)
        {
          $('#chat_history_'+to_user_id).html(data);
          console.log('updating...');
        }
      });
    }
    
    function update_chats()
    {
      $('.chat_history').each(function(){
        var to_user_id = $(this).data('touserid');
        get_chats(to_user_id);
      });
    }
    
    $(document).on('click', '.ui-button-icon', function(){
      $('.user_dialog').dialog('destroy').remove();
    });
  });
  
  </script>