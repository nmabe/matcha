<?php
  require_once 'core/init.php';
  if (Input::exists())
  {
      if (Token::check(Input::get('token')))
      {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'exists' => 'users'),
                'password' => array('required' => true),
                'code' => array('required' => true)
            ));

            if ($validation->passed())
            {
                $user = new User(Input::get('username'));
                if($user && Hash::make(Input::get('password'), $user->data()->salt) === $user->data()->password)
                {
                    if ($user->data()->code === Input::get('code'))
                    {
                        $user->login(Input::get('username'), Input::get('password'));
                        try{
                            DB::getInstance()->update('users', $user->data()->id, array(
                                'active' => 1,
                                'avatar' => 'img/bg/account-green.png'
                            ));
                            Session::flash('success', 'Account Successfully Verified...');
                            Redirect::to('index.php');
                        }catch(PDOException $e){
                            echo($e->getMessage());
                        }
                    }
                    else{
                        echo "Incorrect Verification Code Please Check And Try Again";
                    }
                }
                else
                {
                    echo "Incorrect Password Please Check And Try Again";
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
  <title>Verify Your account</title>
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
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link disabled" href="#" onclick="document.getElementById('id02').style.display='block'">Sign In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" onclick="document.getElementById('id01').style.display='block'">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Find Match</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">My Chats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">About Us</a>
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
            <h1>Verify</h1>
            <p>Please Insert Your Username, Password and Verification Code</p>
            <hr>
            <label for="name"><b>Username</b></label>
            <input class="input input-group-text" type="text" name="username" id="username1" placeholder="Enter your username...">
            <label for="password"><b>Password</b></label>
            <input class="input input-group-text" type="password" name="password" id="password1" placeholder="Enter your password..." >
            <label for="code"><b>Verification Code</b></label>
            <input class="input input-group-text" type="text" name="code" id="code" placeholder="Enter Your Verification Code..." >
            <div class="clearfix">
                <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
                <button class="btn btn-dark" type="submit" class="verifybtn">Verify</button>
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
</html><style type = 'text/css'>
    .flex { display: flex; flex-direction: row; justify-content: center; width: 800px; border: 1px solid gray; padding: 4px;}
    .flex div { border: 1px solid gray; padding: 4px; background: #A4F2D8; font-family: verdana; font-size: 19px; text-align: center; color: gray; }
</style>