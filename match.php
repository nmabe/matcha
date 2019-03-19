<?php
  require_once 'core/init.php';

  $user = new User();
    
    if ($user->isLoggedIn())
    {
      $numOfNotifications = 0;
      $notifications = DB::getInstance();
      $notifications->get('notifications', array('user_id', '=', $user->data()->id));
      if ($notifications->count())
      {
        foreach($notifications->result() as $thesis)
        {
            $numOfNotifications++;
        }
      }
    }

    if (!$user->isLoggedIn()){
      Redirect::to('index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Match</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Text+Me+One" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
  .profpic {
    max-width:300px;
    margin: auto;
    border: 3px solid #333333;
  }
  .location{
    display: block;
    margin:10px;
    width:90%;
    height:200px;
  }
  </style>
</head>
<body>
<div class="bg">
  <div class="jumbotron-fluid text-left" style="margin-bottom:0;">
      <a style="text-decoration: none; color:#f1f1f1;font-family: 'Kumar One Outline', cursive;" href="index.php"><h1>Matcha 💖</h1>
      <p>Find Your Match</p></a>
      <div id="addUser"></div>
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
          <a class="nav-link active" href="match.php">Find Match</a>
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

      $people = new Match($user->data()->id);
      if (Input::exists())
      {
        if (Input::get('age') && Input::get('id') == 11)
        {
          $people = $people->filter_users('age', Input::get('age'));
        }
        else if (Input::get('location') && Input::get('id') == 12)
        {
          $people = $people->filter_users('location', Input::get('location'));
        }else if (Input::get('ratings') && Input::get('id') == 13)
        {
            $people = $people->filter_users('rating', Input::get('ratings'));
        }else if (Input::get('interests') && Input::get('id') == 14)
        {
          $people = $people->filter_users('interests', Input::get('interests'));
        }else if (Input::get('sAge') && Input::get('id') == 15)
        {
          $people = $people->sort_users('age', Input::get('sAge'));
        }else if (Input::get('sLocation') && Input::get('id') == 16)
        {
          $people = $people->sort_users("location", Input::get('sLocation'));
        }else if (Input::get('sRating') && Input::get('id') == 17)
        {
          $people = $people->sort_users('rating', Input::get('sRating'));
        }else if (Input::get('sInterests') && Input::get('id') == 18)
        {
          $people = $people->sort_users("interests", Input::get('sInterests'));
        }else if (isset($_REQUEST['find'])){
          if ($_SERVER["REQUEST_METHOD"] == "POST")
          {
            $q = $_REQUEST["find"];
            $db = DB::getInstance();
            $sql = "SELECT * FROM `users` WHERE `username` LIKE '%$q%' OR `fullname` LIKE '%$q%' OR `location` LIKE '%$q%'";
            $result = $db->query($sql);
            $json = array();
            //$result = $result->result();
            foreach ($result as $res)
            {
                array_push($json, $res->fullname);
            }
            $people = $result;
        }

      }
    }else{
      $people = $people->match_user();
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
            <h3><?php echo $user->data()->fullname ?></h3>
            <p>Age: <?php echo $user->data()->age ?></p>
            <p><?php echo $user->data()->location ?></p>
            <h6>My Image</h6>
            <img class="fakeimg" src="<?php echo $user->data()->avatar?>">
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
            <div class="container" style="margin-top:30px">
                <div class="row">
                  <div class="col-sm-4">
                    <hr class="d-sm-none">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-8">
            <h3>Find Your Match</h3><hr>
            <form class="searchit" method="post" action="#">
                <input style="margin-right:5px;" type="text" name="find" id="find" placeholder="Search..">
            </form>
            <div id="katanga"></div>
            <div class="container w3-blue w3-leftbar">
              <p>Filter</p>
              <div class="form-group">
                <label for="filterByAge">Age</label>
                <select class="form-control-sm" id="filterByAge">
                  <option>- -</option>
                  <option>18 - 25</option>
                  <option>25 - 35</option>
                  <option>35 - 45</option>
                  <option>45 - 55</option>
                  <option>55 - < </option>
                </select>
                <label for="filterByLocation">Location</label>
                <select class="form-control-sm" id="filterByLocation">
                  <option>- -</option>
                  <option>10 - 20 Km </option>
                  <option>25 - 35 Km</option>
                  <option>35 - 45 Km</option>
                  <option>45 - 55 Km</option>
                  <option>55 - < Km</option>
                </select>
                <label for="filterByRating">Rating</label>
                <select class="form-control-sm" id="filterByRating">
                  <option>- -</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
                <label for="filterByInterests">Interests</label>
                <select class="form-control-sm" id="filterByInterests">
                  <option>- -</option>
                  <option>travelling</option>
                  <option>exercising</option>
                  <option>theater</option>
                  <option>cooking</option>
                  <option>outdoors</option>
                  <option>politics</option>
                  <option>pets</option>
                  <option>photography</option>
                  <option>music</option>
                  <option>movies</option>
                  <option>games</option>
                  <option>dancing</option>
                  <option>sports</option>
                  <option>books</option>
                  <option>indoors</option>
                  <option>poetry</option>
                </select>
              </div>
            </div>
            <div class="container w3-aqua w3-leftbar">
              <p>Sort by</p>
              <div class="form-group">
                <label for="sortByAge">Age</label>
                <select class="form-control-sm" id="sortByAge">
                  <option>- -</option>
                  <option>Ascending</option>
                  <option>Descending</option>
                </select>
                <label for="sortByLocation">Location</label>
                <select class="form-control-sm" id="sortByLocation">
                  <option>- -</option>
                  <option>Near - Far</option>
                  <option>Far - Near</option>
                </select>
                <label for="sortByRating">Rating</label>
                <select class="form-control-sm" id="sortByRating">
                  <option>- -</option>
                  <option>Ascending</option>
                  <option>Descending</option>
                </select>
                <label for="sortByInterests">Interests</label>
                <select class="form-control-sm" id="sortByInterests">
                  <option>- -</option>
                  <option>Most</option>
                  <option>Least</option>
                </select>
              </div>
            </div>
              <script type="text/javascript">
                  $(function(){
                    $("#find").autocomplete({
                      source: function(request, response){
                        $.ajax({
                          url: "search.php",
                          dataType: "jsonp",
                          data: {
                            q: request.term
                          },
                          success: function(data){
                            response(data);
                          }
                        });
                      },
                    });
                  });
            </script>
              <hr>
              <div class="container">
  <div class="row">
<?php

if ($people)
{
  $i = 1;
  foreach($people->result() as $results)
  {
    $ids = $results->id;
    $page = "user.php?provID={$ids}";
    ?>
    <div class="col-sm-4" id="usercard">
    <div id="busicard">
   <div class="menu">
    <div class="movembar">
        <a href="#" onclick="addMate(<?php echo $ids?>)" class="mbut"><div class="mbar"></div></a>
    </div>
    <div class="movegear">
        <a href="<?php echo $page?>"><div class="gear"></div></a>
    </div>
   </div>
      <div class="user">
        <img src="<?php echo $results->avatar ?>">
      </div>
      <h1><?php echo $results->fullname ?></h1>
      <h5 id="age"><small>Age</small> : <strong><?php echo $results->age; ?></strong> </h5>
      <h5 id="age"><small>Gender</small> : <strong><?php echo ($results->gender == 1) ? "Male" : "Female"; ?></strong> </h5>
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
    <div class="bfollow">
      <a href="#" onclick="addMate(<?php echo $ids?>)" >Follow</a>
    </div>
  <div class="content">
    <div class="lock"></div>
    <p style="font-size:14px;"><?php echo $results->about ?></p>
  </div>
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
          <script src="js/main.js"></script>
        </div>
      </div>
    </div>
  </div>
  <div class="jumbotron text-center" style="margin-bottom:0">
      <p>&copy Matcha Project By <small><i>nmabe</small></p>
    </div>
  </div>
</body>
</html>
