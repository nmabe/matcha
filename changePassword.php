<?php
  require_once 'core/init.php';

  if (Session::exists(Session::flash('success')))
  {
    echo '<div class="alert">';
    echo '<span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>';
    echo "<strong>warning!</strong> " .Session::flash('success'). "</div>";
    echo '</div>';
  }

  if (Input::exists())
  {
      if (Token::check(Input::get('token')))
      {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'code' => array(
                    'required' => true,
                ),
                    'newPassword' => array(
                    'required' => true,
                    'strong' => true,
                    'min' => 8),
                'CnewPassword' => array(
                    'match' => 'newPassword'
                )
            ));

            if ($validation->passed())
            {
                $username = Input::get('username');
                $user = new User($username);
                $code = Input::get('code');
                if ($code === $user->data()->code)
                {
                    $salt = Hash::salt();
                    $passwd = Hash::make(Input::get('newPassword'), $salt);
                    try{
                        DB::getInstance()->update('users', $user->data()->id, array(
                            'password' => $passwd,
                            'salt' => $salt
                        ));
                        Redirect::to('index.php');

                    }catch(PDOException $e){
                        echo($e->getMessage());
                    }

                }else{

                    die($code ."<===>". $user->data()->code);
                }
            }
            else{
                foreach($validation->error() as $err)
                    echo "{$err}. <br>";
            }
      }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Change Your Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="color:white; opacity:0.5; filter: alpha(opacity=30);">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
        </li>
      </ul>
    </div>
  </nav>
    <!-- Body side bar -->
    <div class="container" style="margin-top:30px">
      <div class="row">
        <div class="col-sm-2">

        <hr class="d-sm-none">
      </div>
          <!-- Body container -->
      <div class="col-sm-8">
      <form class="form form-group" action="#" method="post">
          <div class="container">
            <h2>Change Your Password</h2>
            <p>Please Insert Your Unique Code and New Password</p>
            <hr>
            <label class="label col-form-label" for="code"><b>code</b></label>
            <input class="form-control" type="text" name="code" id="code" placeholder="Enter your unique code...">
            <label class="label col-form-label" for="newPassword"><b>New Password</b></label>
            <input class="form-control" type="password" name="newPassword" id="newPassword" placeholder="Enter your new password..." >
            <label class="label col-form-label" for="CnewPassword"><b>Confirm New Password</b></label>
            <input class="form-control" type="password" name="CnewPassword" id="CnewPassword" placeholder="Enter your new password..." >
            <div class="clearfix">
                <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
                <button class="btn btn-info" type="submit">Change Password</button>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
  <div class="jumbotron text-center" style="margin-bottom:0">
  <p>&copy Matcha Project By <small><i>nmabe</small></p>
  </div>
</div>
</body>
</html>