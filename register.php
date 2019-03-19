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
                            'min' => 2,
                            'max' => 20,
                            'unique' => 'users'
                    ),
                    'fullname' => array(
                            'required' => true,
                            'min' => 2,
                            'max' => 50
                    ),
                    'email' => array(
                            'required' => true,
                            'min' => 8
                    ),
                    'gender' => array(
                            'required' => true,
                            'gender' => array('Male','Female')
                    ),
                    'dob' => array(
                            'required' => true,
                            'restriction' => 18
                    ),
                    'address' => array(
                            'required' => true,
                            'min' => 15
                    ),
                    'city' => array(
                        'required' => true
                    ),
                    'password' => array(
                            'required' => true,
                            'min' => 8,
                            'strong' => true
                    ),
                    'password_again' => array(
                            'required' => true,
                            'match' => 'password'
                    ),
            ));


            if (Input::get('city'))
            {
                if (Input::get('city') == "Johannesburg")
                {
                    $latitude = Config::get('cities/LatitudeJhb');
                    $longitude = Config::get('cities/LongitudeJhb');
                }else if (Input::get('city') == "Durban")
                {
                    $latitude = Config::get('cities/LatitudeDbn');
                    $longitude = Config::get('cities/LongitudeDbn');
                }else if (Input::get('city') === "Cape Town")
                {
                    $latitude = Config::get('cities/LatitudeCpt');
                    $longitude = Config::get('cities/LongitudeCpt');
                }else if (Input::get('city') == "Pretoria")
                {
                    $latitude = Config::get('cities/LatitudePta');
                    $longitude = Config::get('cities/LongitudePta');
                }else if (Input::get('city') == "Rustenburg")
                {
                    $latitude = Config::get('cities/LatitudeRtn');
                    $longitude = Config::get('cities/LongitudeRtn');
                }else if (Input::get('city') === "Port Elizabeth")
                {
                    $latitude = Config::get('cities/LatitudePE');
                    $longitude = Config::get('cities/LongitudePE');
                }else if (Input::get('city') == "Nelspruit")
                {
                    $latitude = Config::get('cities/LatitudeNsp');
                    $longitude = Config::get('cities/LongitudeNsp');
                }else if (Input::get('city') === "Bloemfontain")
                {
                   $latitude = Config::get('cities/LatitudeBlm');
                   $longitude = Config::get('cities/LongitudeBlm');
                }else if (Input::get('city') === "Polokwane")
                {
                    $latitude = Config::get('cities/LatitudePlk');
                    $longitude = Config::get('cities/LongitudePlk');
                }else{
                    $latitude = Config::get('cities/Latitude');
                    $longitude = Config::get('cities/Longitude');
                }
            }
            if ($validation->passed()) {
                $user = new User();
                $salt = Hash::salt();
                $code = rand(12345,67890);
                $age = (intval(date('Y')) - intval(explode('-', $_POST['dob'])[0]));
                $fields = array(
                    'id' => null ,
                    'username' => Input::get('username'),
                    'fullname' => Input::get('fullname'),
                    'gender' => (Input::get('gender') === 'Male') ? 1 : 0,
                    'email' => Input::get('email'),
                    'about' => 'N/A',
                    'avatar' => 'img/bg/account-red.png',
                    'age' => $age,
                    'location' => Input::get('address'),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'code' => $code,
                    'joined' => escape(date('Y-m-d H:i:s')),
                    'notify' => 1,
                    'active' => 0,
                    'group' => 0,
                    'visits' => 0
                );
                try {
                    $user->create($fields);
                    try{
                        if ($validation->Verifymail($code, Input::get('username') , Input::get('email')))
                        {
                            Session::flash('success', 'Account Has Been Created Successfully');
                           // Redirect::to('verify.php');
                        }
                    }catch (PDOException $e){
                        echo($e->getMessage());
                    }
                }catch (PDOException $e){
                    echo($e->getMessage());
                }
            }
            else{
                foreach ($validation->error() as $er)
                {
                    echo $er.'<br>';
                }
            }
        }
    }


    echo '<h4> '. Session::flash('success') . '</h4><br>';



?>