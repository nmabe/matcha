<?php
    require_once 'core/init.php';

    if (Input::exists())
    {
        if (Token::check(Input::get('token')))
        {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
            ));

            if ($validation->passed())
            {
                $remember = (Input::get('remember') ? true : false);
                $user = new User();
                $login = $user->login(Input::get('username'), Input::get('password'), $remember);
                if ($login)
                {
                    Session::flash('success', "Welcome back {$user->data()->fullname}");
                }
                else
                {
                    echo '<p>Error Loggin user please check your details and try again.</p>';
                }
            }
            else
            {
                foreach( $validation->error() as $error)
                {
                    echo "{$error} <br>";
                }
            }
        }
    }

    echo '<h4>'. Session::flash('success').'</h4><br>';
?>