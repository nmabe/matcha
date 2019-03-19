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
                'email' => array(
                  'required' => true,
                  ),
            ));

            if ($validation->passed())
            {
              $code = rand(12345,67890);
              $id = DB::getInstance();
              $id->get('users', array('username', '=', Input::get('username')));
              if ($id->first()->email === Input::get('email'))
              {
                $username = $id->first()->username;
                  $id = $id->first()->id;
                  $mail = new Mail($id);
                  $change = $mail->changePassword($code);
                  if ($change)
                  {
                    try{
                      DB::getInstance()->update('users', $id, array(
                        'code' => $code
                      ));
                    }catch(PDOException $e){
                      echo $e->getMessage();
                    }
                    Session::flash('success', 'Unique Has Been Created Successfully And Sent Tour Email');
                    Redirect::to('changePassword.php?username='.$username);
                  }else{
                    echo "<h3>There Was An Error Changing Your Password Please Try Again! <h3/>";
                  }
              }else{
                  echo "<h3>Unknown Email Address Please Use Your Matcha Account Email<h3/>";
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
  <title>Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
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
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
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
            <p>Please Insert Your Username, and Email</p>
            <hr>
            <label class="label col-form-label" for="name"><b>Username</b></label>
            <input class="form-control" type="text" name="username" id="username1" placeholder="Enter your username...">
            <label class="label col-form-label" for="email"><b>Email</b>
            <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email..." >
            </label>
            <div class="clearfix">
                <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
                <button class="btn btn-info" type="submit" >Send Code</button>
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