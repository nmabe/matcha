<?php
  require_once 'config/database.php';
  init();
 
  require_once 'core/init.php';
  $user = new User();
  
  if ($user->isLoggedIn())
  {
    $notifications = DB::getInstance();
    $notifications->get('notifications', array('user_id', '=', $user->data()->id));
    $numOfNotifications = 0;
    if ($notifications->count())
    {
      foreach($notifications->result() as $thesis)
      {
        $numOfNotifications++;
      }
    }
  }
  
  $token = Token::generate();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/style.css">
  
</head>
<body>
<div class="bg">
  
  <div class="jumbotron-fluid text-left" style="margin-bottom:0;">
      <a style="text-decoration: none; color:#f1f1f1;font-family: 'Kumar One Outline', cursive;" href="index.php"><h1>Matcha 💖</h1>
      <p>Find Your Match</p></a>
    </div>
  <?php
  if($user->isLoggedIn())
  {
    if ($user->data()->active == 0)
    {
      ?>
        <div class="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
          <strong>warning!</strong> Please check your email and activate your account to start finding your match</div>
        </div>
      <?php
    }
  }
  ?>
  <div id="flash"></div>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="color:white; opacity:0.5; filter: alpha(opacity=30);">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>

    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <?php
        if (!$user->isLoggedIn())
        {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="document.getElementById('id02').style.display='block'">Sign In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="document.getElementById('id01').style.display='block'">Sign Up</a>
        </li>
        <?php }else{?>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="document.getElementById('id03').style.display='block'">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="match.php">Find Match</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chats.php">My Chats</a>
        </li>
        <?php
        }?>
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
                <li>
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
                </li>
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
  <div id="addUser"><span>
        <!--
        Register Modal
      -->
  <div id="id01" class="modal">
      <span onclick="document.getElementById('id01').style.display='none'"; class="close" title="Close Modal">&times;</span>
      <form id="regForm" class="modal-content"  method="post">
          <div class="container">
            <h1>Sign up</h1>
            <span style="color: green"><a href="#" onclick="document.getElementById('id02').style.display='block';document.getElementById('id01').style.display='none'" >Already Have Account ?</a></span>
            <p>Please Fill In This Form To Create An Account</p>
            <hr>
            <label for="name"><b>Username</b>
            <input type="text" name="username" id="username" placeholder="choose your username...">
            </label>
            <label for="fullname"><b>Fullname</b>
            <input type="text" name="fullname" id="fullname" placeholder="enter your full name...">
            </label>
            <label for="email"><b>Email</b>
            <input type="text" name="email" id="email" placeholder="enter your email...">
            </label>
            <label for="gender"><b>Gender</b>
            <select name="gender" id="gender" required>
              <option value="" disabled selected>Select your gender...</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            </label>
            <label for="dob"><b>Date of Birth</b>
            <input type="date" name="dob" id="dob" placeholder="Enter Your Date of Birth" >
            </label>
            <label for="address"><b>Address</b>
          </label>
          <input type="text" name="address" id="address" placeholder="Enter Your Physical Address..." >
            <label for="city"><b>City</b>
            <select name="city" id="city" required>
              <option value="" disabled selected>Select your City...</option>
              <option value="Johannesburg">Johannesburg</option>
              <option value="Durban">Durban</option>
              <option value="Cape Town">Cape Town</option>
              <option value="Pretoria">Pretoria</option>
              <option value="Rustenburg">Rustenburg</option>
              <option value="Polokwane">Polokwane</option>
              <option value="Bloemfontein">Bloemfontein</option>
              <option value="Port Elizabeth">Port Elizabeth</option>
              <option value="Nelspruit">Nelspruit</option>
              <option value="Other">Other</option>
            </select>
            </label>
            <label for="password"><b>Password</b>
            <input type="password" name="password" id="password" placeholder="choose a password...">
            </label>
            <label for="password_again"><b>Confirm Password</b>
            <input type="password" name="password_again" id="password_again" placeholder="confirm your password..."></label>
            <p> By creating an account you are agree to our <a href="#" style="color:aqua">terms & privacy</a></p>
              <input type="hidden" name="token" id="token" value="<?php echo $token ?>" >
            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <button id="signup" type="submit" class="signupbtn">Sign Up</button>
            </div>
          </div>
      </form>
    <script>
      var modal = document.getElementById('id01');

      window.onclick = function(event)
      {
        if (event.target == modal){
          modal.style.display = 'none';
        }
      }
    </script>
    </div>
      <!--
        Login Modal
      -->
      <div id="id02" class="modal">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <form class="modal-content" id="loginForm" method="post">
          <div class="container">
            <h1>Sign In</h1>
            <span style="color: green"><a href="#" onclick="document.getElementById('id01').style.display='block';document.getElementById('id02').style.display='none'">Need An Account ?</a></span>
            <p>Please Fill In This Form To Sign In To Your Matcha Account</p>
            <hr>
            <label for="name"><b>Username</b></label>
            <input type="text" name="username" id="username1" placeholder="choose your username...">
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" id="password1" placeholder="choose a password..." >
            <input type="checkbox" name="remember"> Remember Me?
            <span style="color:red; left:20;"><a href="forgot.php">Forgot Password</a></span>
            <div class="clearfix">
                <input name="token" type="hidden" value="<?php echo $token ?>">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                <button id="login" type="submit" class="signupbtn">Sign In</button>
            </div>
          </div>
      </form>
    <script>
      var modal = document.getElementById('id02');

      window.onclick = function(event)
      {
        if (event.target == modal){
          modal.style.display = 'none';
        }
      }
    </script>
      </div>
      <!--
        Logout Modal
      -->
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
    <!-- Body side bar -->
    <script src="js/main.js"></script>
    <?php 
    if ($user->isLoggedIn())
    {
    ?>
    <div class="container" style="margin-top:30px z-index:4">
      <div class="row">
        <div class="col-sm-3">
        <h3><?php echo $user->data()->fullname ?></h3>
        <p>Age: <?php echo $user->data()->age ?></p>
        <p><?php echo $user->data()->location ?></p>
        <h6>My Image</h6>
        <img class="fakeimg" src="<?php echo $user->data()->avatar?>" style="margin:2px;" width="280" height="196"> 
        <h4>My Profile</h4>
        <p>View Your Profile Here</p>
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="profile.php">My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($user->data()->active == 0){ echo "disabled";} ?>" href="chats.php">My Chats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($user->data()->active == 0){ echo "disabled";} ?>" href="mymatch.php">My Match</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($user->data()->active == 0){ echo "disabled";} ?>"  href="editprofile.php">Edit Profile</a>
          </li>
        </ul>
        <hr class="d-sm-none">
      </div>
    <?php }else{?>
      <div class="container" style="margin-top:30px">
      <div class="row">
        <div class="col-sm-3">
        <hr class="d-sm-none">
      </div>
    <?php } ?>
          <!-- Body container -->
      <div class="col-sm-9">
      <div class="container">
  <div class="row">
<?php

if (!$user->isLoggedIn())
  {
    $users = DB::getInstance()->get('users', array('id', '<>', '0'));
  }else{
    $users = DB::getInstance()->get('users', array('id', '<>', $user->data()->id));
  }

if ($users->count())
{
  $i = 1;
  foreach($users->result() as $results)
  {
    ?>
    <div class="col-sm-4">
    <div id="busicard">
    <?php
      if ($user->isLoggedIn())
      {
        $userID = $results->id;
        $check = false;
        try{
          $check = DB::getInstance()->query("SELECT * FROM `mates` WHERE (`reqID` = {$user->data()->id} AND `provID` = {$userID}) OR (`reqID` = {$userID} AND `provID` = {$user->data()->id})");
          if ($check->count())
          {
            $check = true;
          }else{
            $check = false;
          }
        }catch(PDOException $e)
        {
          echo $e->getMessage();
        }
        $url = "user.php?provID={$userID}";
        ?>
            <div class="menu">
            <div class="movembar">
                <a href="#" class="mbut" onclick"addMate(<?php echo $userID; ?>)"><div class="mbar"></div></a>
            </div>
            <div class="movegear">
                <a href="<?php echo $url; ?>"><div class="gear"></div></a>
            </div>
            </div>
        <?php
      }else{
        ?>
           <div class="menu">
            <div class="movembar">
                <a href="#" onclick="document.getElementById('id02').style.display='block'" class="mbut"><div class="mbar">
                </div></a>
            </div>
            <div class="movegear">
                <a href="#" onclick="document.getElementById('id02').style.display='block'" ><div class="gear">

                </div></a>
            </div>
          </div>
        <?php
      }
    ?>
      <div class="user">
        <img src="<?php echo $results->avatar ?>">
      </div>
      <h1><?php echo $results->fullname ?></h1>
      <ul class="info">
        <li><?php echo $results->location ?></li>
        <!---  <span class="hrtop"></span>
        <li>Nihilist</li>
          <span class="hrtop"></span>
        <li>Skater</li> -->
      </ul>
    <ul class="contacts">
      <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
      <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
      <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
    </ul>
    <?php
      if ($user->isLoggedIn())
      {
        if ($check == true)
        {
          echo "<div class=\"bfollow\">
                <a href=\"\" id=\" $userID \" class=\"removeUser\">Following</a>
              </div>";
        }else{
          echo "<div class=\"bfollow\">
                <a href=\"\" id=\" $userID \" class=\"addUser\">Follow</a>
              </div>";
        }

        ?>
        <div class="content">
          <div class="fa-lock"><h4>About</h4></div><br>
          <p style="font-size:14px;"><?php echo $results->about ?></p>
        </div>
        <?php
      }else{
        ?>
          <div class="content">
            <div class="lock"></div>
            <p style="font-size:14px;">Sign in to see content!</p>
          </div>
        <?php
      }
    ?>
</div>
<!-- 
Thank you for watching c;
-->
    </div>
    <?php
  }
}
?>
  </div>
</div>
      </div>
</div>
<script>

$('.addUser').on('click', function(){
  var id = $(this).attr('id');
    addMate(id); 
});

$('.removeUser').on('click', function(){
  var id = $(this).attr('id');
  cancelMate(id); 
});
</script>
<script type="text/javascript" src="js/main.js"></script>
  <div class="jumbotron text-center" style="margin-bottom:0">
  <p>&copy Matcha Project By <small><i>nmabe</small></p>    
  </div>
</div>
    </div>
</body>
</html>
