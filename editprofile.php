<?php
  require_once 'core/init.php';

  $user = new User();
  $myinterests = array();
  $sex = NULL;
  
  if (isset($_POST['five'])){
    if (!empty($_FILES['five_image']['name']))
    {
      $upload = new Update($user->data()->id);
      $save = $upload->upload_pics();
      if ($save)
      {
        echo '<script language="javascript">';
        echo 'alert("Itseni kafa!")';
        echo '</script>';
      }
    }
  }
  
  if (Input::exists())
  {
    if (Token::check(Input::get('token')))
    {
      if (!empty($_FILES['avatar']['name']))
      {
        $saveImg = new Update($user->data()->id);
        $saved = $saveImg->upload();
        if($saved) {
          echo "<p>Your Avatar Has been Successfully Changed<br></p>";
        }else{
          echo  "Ay Kuya bheda mos Lesthombe asingenanga...";
        }
      }
      

        if ((empty(Input::get('new_password')) && !empty(Input::get('password_again'))) || (!empty(Input::get('new_password')) && empty(Input::get('password_again'))))
        {
          if (empty(Input::get('new_password')))
          {
              echo '<script language="javascript">';
              echo 'alert("Enter Your New Password You Cant Just Confirm nje!")';
              echo '</script>';
            }else{
              echo '<script language="javascript">';
              echo 'alert("Please Confirm Your New Password!")';
              echo '</script>';
          }
        }
        $update = new Update($user->data()->id);
        $update->validate();
        if ($update->passed())
        {
          $update->details();
        }
        else{
            foreach($update->error() as $err)
              echo("<p>{$err}</p><br>");
        }
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
  <title>My Profile </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-2.1.3.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .btn-xs{
      width:30%;
      margin: 5px;
    }
    .interesting{
      padding: 10px;
    }
    ul.demo {
    list-style-type: none;
    margin: 0;
    padding: 0;
    color: #009999;
  }
  ul.demo p{
    color: #333333;
  }

  </style>
</head>
<body>
<div class="bg">
  
  <div class="jumbotron-fluid text-left" style="margin-bottom:0;">
      <a style="text-decoration: none; color:#f1f1f1;font-family: 'Kumar One Outline', cursive;" href="index.php"><h1>Matcha 💖</h1>
      <p>Find Your Match</p></a>
  </div>
  <?php
      if ($user->data()->active == 0)
      {
        ?>
          <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>warning!</strong> Please check your email and activate your account to start finding your match</div>
          </div>
        <?php
      }
  ?>
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
          <a class="nav-link" href="chats.php">My Chats</a>
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
        <div class="container" style="margin-top:30px">
            <div class="row">
            <div class="col-sm-4">
            <h3>My Profile</h3>
                <p>View Your Profile Here</p>
                <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chats.php">My Chats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mymatch.php">My Match</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active <?php if($user->data()->active == 0){ echo "disabled";} ?>" href="editprofile.php">Edit Profile</a>
                </li>
                </ul>
                <br><hr>
                <img class="fakeimg" src="<?php echo $user->data()->avatar;?>" alt="<?php echo $user->data()->fullname;?>">
                  <div class="w3-container">
                  <h1 style="color:#333333"><?php echo $user->data()->fullname;?></h1>
                      <ul class="demo">
                          <li>Username: <p><?php echo $user->data()->username;?></p></li>
                          <li>Full Name: <p><?php echo $user->data()->fullname;?></p></li>
                          <li>Gender: <p><?php echo ($user->data()->gender == 0) ? "Female" : "Male";?></p></li>
                          <li>Age: <p><?php echo $user->data()->age;?></p></li>
                          <li>Email: <p><?php echo $user->data()->email;?></p></li>
                          <li>Address: <p><?php echo $user->data()->location;?></p></li>
                      </ul>
                      <?php
                      $intr = DB::getInstance()->get('interests', array('user_id', '=', $user->data()->id));
                      if ($intr->count())
                      {
                          $min = $intr->first()->min;
                          $max = $intr->first()->max;
                          foreach($intr->first() as $keys => $interests)
                          {
                            if ($keys == 'gender')
                            $sex = $interests;
                            if ($keys !== 'id' && $keys !== 'user_id' && $interests == 1 && $keys !== 'gender')
                            $myinterests[] = $keys;
                          }
                          if ($sex != NULL) {
                            if ($sex == 0)
                            $sex = "Female";
                            elseif ($sex == 1)
                            $sex = "Male";
                            else
                            $sex = "Male & Female";
                          }else{
                            $sex = "-";
                          }
                        }
                      ?>
                  <h5>About</h5>
                  <p style="color:#333333"><?php echo $user->data()->about;?></p>
                  <div class="container" style="border: 1px solid #33fcfc; border-radius:15px;">
                  <h5>Interests</h5>
                  <div id="myInterests">
                        <?php
                            if(count($myinterests)) {
                                foreach ($myinterests as $interests)
                                    echo "<div class=\"interests\"><p>{$interests}</p></div>";
                            }
                        ?>
                  </div>
                  </div>
                      <br>
                      <p style="color:#00fcfc">Interested In: <?php if($sex){echo $sex;}else{echo "-";}?></p>
                </div>
                <hr class="d-sm-none">
            </div>
            <div class="col-sm-8">
            <div id="katris"></div>
            <div class="w3-container" >
            </div>
              <div class="w3-container w3-white">
                    <h3>Edit Your Profile</h3><br>
                    <form action="#" enctype="multipart/form-data" method="post">
                      <label for="fullname">Full Name<input class="form-control" type="text" name="fullname" placeholder="change your name..."></label>
                      <label for="address">Address<input class="form-control" type="address" name="address" placeholder="change your address..."></label>
                      <label  for="city"><b>City</b>
                      <select  name="city" id="city" required>
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
                      <label for="avatar">Upload Profile Picture<input class="form-control" type="file" name="avatar" placeholder="change your avatar..."></label>
                      <label for="email">Email<input class="form-control" type="email" name="email" placeholder="change your email address..."></label>
                      <label for="about">About<textarea rows="4" cols="95" class="form-control" name="about" placeholder="about yourself..."></textarea></label>
                      <span>
                      <label style="width:49%" for="new_password">New Password<input class="form-control" type="password" name="new_password" placeholder="change your passowrd..."></label>
                      <label style="width:49%" for="password_again">Confirm Password<input class="form-control" type="password" name="password_again" placeholder="confirm your new password..."></label>
                      <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
                      <button type="submit" class="btn" name="update">Update Profile</button>
                    </form>
              </div>
              <hr>
              <div class="w3-container w3-white">
                    <h3>Preferences</h3><br>
                    <form id="preferences" name="preferences" method="post">
                    <label for="genders"><b>Interested in</b>
                      <select name="genders" id="genders" required>
                        <option value="" disabled selected>Select your prefered gender...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Both">Both</option>
                      </select><br><br>
                      <div class="container" style="border: 1px solid #33fcfc; border-radius:15px;">
                        <label for="interests"><strong>Interests</strong></label>
                        <div class="interesting" >

                        <?php
                          if ($intr->count())
                          {
                            foreach($intr->first() as $keys => $interests)
                            {
                              if ($keys !== 'id' && $keys !== 'user_id' && !$interests && $keys !== 'gender')
                                echo "<button type=\"button\" id=\"$keys\" class=\"btn btn-info btn-xs\"> $keys </button>";
                            }
                          }
                          else{
                            $intr = DB::getInstance()->query("SHOW COLUMNS FROM db_matcha.interests", array());
                            if ($intr->count())
                            {
                                foreach ($intr->result() as $keys)
                                {
                                  foreach ($keys as $key => $val)
                                  {
                                    if (($key === 'Field' && $val !== 'id') && ($key === 'Field' && $val !== 'user_id') && ($key === 'Field' && $val !== 'gender'))
                                      echo "<button type=\"button\" id=\"$val\" class=\"btn btn-info btn-xs\"> $val </button>";
                                  }
                              }
                            }
                          }
                        ?>
                        <input type="hidden" value="<?php echo $user->data()->id ?>" id="pref">
                      </div>
                      <div class="interesting">
                        <hr>
                        <label for="interests"><strong>Age Range</strong></label>
                          <p>
                           <label for="age-min">Min: <input type="text" id="age-min" readonly style="border:0; color:#f6931f; font-weight:bold;" ></label>
                           <label for="age-max">Max: <input type="text" id="age-max" readonly style="border:0; color:#f6931f; font-weight:bold;"></label>
                           <input type="hidden" id="min-age-range" value="<?php echo $min?>">
                           <input type="hidden" id="max-age-range" value="<?php echo $max?>">
                          </p>
                          <div id="slider-range"></div><br>
                          <input type="button" class="btn btn-info btn-s" name="addRange" onclick="addingRange()" value="Set Range" style="margin:5px">
                      </div>
                      <script>
                        $( function() {
                          $( "#slider-range" ).slider({
                            range: true,
                            min: 18,
                            max: 99,
                            values: [ document.getElementById('min-age-range').value , document.getElementById('max-age-range').value ],
                            slide: function( event, ui ) {
                              $( "#age-min" ).val( ui.values[ 0 ]);
                              $("#age-max").val( ui.values[ 1 ]);
                            }
                          });
                          $( "#age-min" ).val( $( "#slider-range" ).slider( "values", 0 ));
                          $("#age-max").val($( "#slider-range" ).slider( "values", 1 ) );

                        } );

                      </script>
                    </form>
              </div>
            </div>
            <script src="js/main.js"></script>
            <hr>
            <div class="container w3-white" style="padding: 5px;" >
              <h3> Upload Your Pictures </h3>
              <div style="border: 1px solid #33fcfc; border-radius:15px; height:45px; margin:5px;">
                <form action="#" enctype="multipart/form-data" method="post">
                    Select images: <input type="file" name="five_image" multiple>
                  <input type="submit" class="btn btn-secondary btn-group-sm" name="five">
                </form>
              </div>
            </div>
        </div>
        </div>

  <div class="jumbotron text-center" style="margin:10px 0 10px 0">
  <p>&copy Matcha Project By <small><i>nmabe</small></p>
  </div>
</div>
</body>
</html>
