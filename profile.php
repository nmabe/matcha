<?php
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
  }else{
    Redirect::to('index.php');
  }
  //$path_images = DB::getInstance()->get('users',array('id', '=', $user->data()->id));
  $visitors = $user->data()->visitors;
  $visits = $user->data()->visits;
  $ratings = $user->data()->ratings;
  $visitors = unserialize($visitors);
  $myinterests = array();
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>
    <link href="https://fonts.googleapis.com/css?family=Text+Me+One" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="js/main.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
  .profpic {
    max-width:300px;
    margin: auto;
    border: 3px solid #333333;
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
                    <a class="nav-link active" href="#">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chats.php">My Chats</a>
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
              <img class="fakeimg" src="<?php echo $user->data()->avatar;?>" alt="<?php echo $user->data()->fullname;?>">
              <h2><?php echo $user->data()->fullname?></h2>
                <span class="heading">User Rating</span>
                <span class="fa fa-star <?php echo ($ratings > 0.5) ? "checked" : ""?>"></span>
                <span class="fa fa-star <?php echo ($ratings > 1.5) ? "checked" : ""?>"></span>
                <span class="fa fa-star <?php echo ($ratings > 2.5) ? "checked" : ""?>"></span>
                <span class="fa fa-star <?php echo ($ratings > 3.5) ? "checked" : ""?>"></span>
                <span class="fa fa-star <?php echo ($ratings > 4.5) ? "checked" : ""?>"></span>
                <p><?php echo $ratings ." average based on ".$visits?> reviews.</p>
                <hr style="border:3px solid #f1f1f1">
              <div class="w3-container w3-blue">
                <h3>My Images</h3>
              </div>
              <div class="w3-row-padding w3-margin-top">
              <?php
                    $image = unserialize($user->data()->images);
                    //print_r($image);
                    //die("<br>images: ".count($image));
                    if (!empty($image))
                    {
                      ?>
                       <div id="myCarousel" class="carousel slide" data-ride="carousel">
                      <!-- Indicators -->
                      <ol class="carousel-indicators">
                        <?php
                              $i = 0;
                              foreach ($image as $num)
                              {
                                ?>
                                  <li data-target="#myCarousel" data-slide-to="<?php echo $i?>" <?php if($i == 0){echo "class=\"active\"";} ?>></li>
                                <?php
                                $i++;
                              }
                        ?>
                      </ol>
                      
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                              
                      <?php
                          $x = 0;
                          foreach ($image as $key => $pic)
                          {
                            ?>
                            
                            <div <?php if ($x == 0){ echo "class=\"item active\""; }else{ echo "class=\"item\"";} ?>>
                              <img src="<?php echo $pic['img'] ?>" alt="<?php echo $pic['filename'] ?>">
                            </div>
                          <?php 
                          $x++;
                          }
                      ?>
                      
                      </div>
                      
                      <!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                      <?php
                    }else{
                      echo "<h3> No Images </h3>";
                      echo "<div class=\"responsive\">";
                      echo "<img src=\"img/bg/Sad_Face_Emoji.png\" style\"width:300px; right: 25px;>";
                      echo "</div>";
                    }
              ?>
              </div>
              <hr style="border:3px solid #f1f1f1">
              <div class="w3-container">
              <div class="w3-container w3-blue">
                <h3>My Personal Details</h3>
              </div>
              <br>
                <article>
                    <p>Username: <?php echo $user->data()->username;?></p>
                    <p>Full Name: <?php echo $user->data()->fullname;?></p>
                    <p>Gender: <?php echo ($user->data()->gender == 0) ? "Female" : "Male";?></p>
                    <p>Age: <?php echo $user->data()->age;?></p>
                    <p>Address: <?php echo $user->data()->location;?></p>
                </article>
                <hr style="border:3px solid #f1f1f1">
                <div class="w3-container w3-blue">
                  <h3>My Bio</h3>
                </div>
                <p style="color:#333333"><?php echo $user->data()->about;?></p>
                <hr style="border:3px solid #f1f1f1"><br>
                <div class="w3-container w3-blue">
                    <h3>Location</h3>
                  </div>
                  <br>
                <p id="address"><?php echo $user->data()->location?></p>
                <input type="hidden" id="latitude" name="latitude" value="<?php echo $user->data()->latitude;?>">
                <input type="hidden" id="longitude" name="longitude" value="<?php echo $user->data()->longitude;?>">
                
                <div id='mapid' style="height:280px; background: #ccc"></div>
                    <script>
                        var latitude = document.getElementById('latitude').value;
                        var longitude = document.getElementById('longitude').value;
                        var map = L.map('mapid').setView([latitude, longitude], 14); 
                        console.log('latitude: ' + latitude + '\nlongitude: ' + longitude);
                    
                        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                          id: 'mapbox.streets',
                          accessToken: 'pk.eyJ1Ijoibmt1bHVsZWtvIiwiYSI6ImNqcXl3ODQxeTA3ZXc0M3BvenN6dGJvdmsifQ.WnNR-As71Qolp-lOEUO1Jg'
                        }).addTo(map);
                        
                        var circle = L.circle([51.508, -0.11], {
                            color: 'blue',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 500
                        }).addTo(map);

                    </script>
              </div>
              <?php
              $intr = DB::getInstance()->get('interests', array('user_id', '=', $user->data()->id));
                      if ($intr->count())
                      {
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
                      }else{
                        $sex = 'undefined';
                      }
                ?>
                <hr style="border:3px solid #f1f1f1">
                <div class="container">
                <div class="w3-container w3-blue">
                  <h3>My interests</h3>
                </div>
                  <div>
                  <?php
                    if ($myinterests){
                            if($intr->count()) {
                                foreach ($myinterests as $interests)
                                {
                            ?>
                              <div class="interests">
                                <p><strong><?php echo($interests);?></strong></p>
                              </div>
                              <?php
                              }
                            }}
                        ?>
                </div>
                <br><hr style="border:3px solid #f1f1f1"><br>
                  <div class="w3-container w3-blue">
                    <h3>My Sexual Preferences</h3>
                  </div>
                  <div class="interests">
                      <p><strong><?php echo($sex);?></strong></p>
                  </div>
                </div>
                <hr style="border:3px solid #f1f1f1">
                <div class="container">
                  <div class="w3-container w3-blue">
                    <h3>My Interactions</h3>
                  </div>
                  <div class="w3-container w3-white" style="overflow-y: scroll;">
                    <ul>
                  <?php
                      echo "<h6> Views </h6><hr>";
                      if ($visitors){
                        foreach($visitors as $view)
                        {
                          $name = $view['user'];
                          $user_id = $view['id'];
                          $url = "user.php?provID=".$user_id;
                          $date_t = $view['date'];
                          $avatar = $view['pic'];
                          ?>
                            <li class="w3-bar">
                            <span onclick="this.parentElement.style.display='none'" 
                            class="w3-bar-item w3-button w3-xlarge w3-right">&times;</span>
                            <a href="<?php echo $url?>">
                            <img src="<?php echo $avatar ?>" class="w3-bar-item w3-circle" style="width:85px">
                            <div class="w3-bar-item">
                              <span class="w3-large"><?php echo $name ?></span><br>
                              <span><?php echo $date_t ?></span>
                            </div>
                            </a>
                          </li>
                          <?php
                        }
                      }else{
                        echo("No Views");
                      }
                        ?>
                    </ul>    
                </div>
                </div>
            </div>
            <br>
            <hr style="border:3px solid #f1f1f1">
            <br>
          </div>
        </div>
          
  <div class="jumbotron text-center" style="margin-bottom:0">
  <p>&copy Matcha Project By <small><i>nmabe</small></p>    
  </div>
</div>
</body>
</html>
