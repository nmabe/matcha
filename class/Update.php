<?php

class Update
{
    private $_fullname,
            $_address,
            $_email,
            $_about,
            $avatar,
            $_password,
            $_user,
            $_validate,
            $_city,
            $_error = array(),
            $_passed = false;
            
    public function __construct($user)
    {
        $this->_user = new User($user);
        $this->_validate = new Validate();
        $this->_fullname = (!empty(Input::get('fullname')) ? true : false);
        $this->_address= (!empty(Input::get('address')) ? true : false);
        $this->_avatar = (!empty(Input::get('avatar')) ? true : false);
        $this->_email = (!empty(Input::get('email')) ? true : false);
        $this->_about = (!empty(Input::get('about')) ? true : false);
        $this->_passowrd = (!empty(Input::get('new_password')) ? true : false);
        $this->_city = (!empty(Input::get('city')) ? true : false);
    }

    public function validate()
    {
        $this->_validate->check($_POST, array(
            'fullname' => array(
            'min' => 3,
            'max' => 50
            ),
            'address' => array(
            'min' => 15
            ),
            'email' => array(
            'min' => 8,
            ),
            'about' => array(
            'max' => 500
            ),
            'new_password' => array(
            'strong' => true,
            'min' => 8,
            ),
            'password_again' => array(
            'match' => 'new_password'
            )
        ));

        if ($this->_validate->passed())
        {
            $this->_passed = true;
        }else{
            foreach($this->_validate->error() as $err)
                $this->_error[] = $err;
        }
        return ($this);
    }

    public function details()
    {
        if ($this->_fullname)
          {
            try{
                DB::getInstance()->update('users', $this->_user->data()->id,array( 
                    'fullname' => Input::get('fullname')
            ));
            echo '<p>Fulname Updated...</p>';
            }catch(PDOException $e)
            {
              echo($e->getMessage());
            }
          }

          if ($this->_address)
          {
            try{
                DB::getInstance()->update('users', $this->_user->data()->id,array(
                    'location' => Input::get('address')
            ));
            echo '<p>Your Address Has Been Successfully Updated...</p>';
            }catch(PDOException $e)
            {
              echo($e->getMessage());
            }
          }

          if ($this->_email)
          {
            try{
                DB::getInstance()->update('users', $this->_user->data()->id,array(
              'email' => Input::get('email')
            ));
            echo '<p>Your Email Address Has been Successfully Updated...</p>';
            }catch(PDOException $e)
            {
              echo($e->getMessage());
            }
          }

          if ($this->_about)
          {
            try{
                DB::getInstance()->update('users', $this->_user->data()->id , array(
                    'about' => Input::get('about')
            ));
            echo '<p>Your About Has been Successfully Updated...</p>';
            }catch(PDOException $e)
            {
              echo($e->getMessage());
            }
          }

          if ($this->_password)
          {
            try{
                DB::getInstance()->update('users', $this->_user->data()->id,array(
              'password' => Hash::make(Input::get('new_password'), $this->_user->data()->salt)
            ));
            echo '<p>Your Password Has Been Successfully Updated</p>';
            }catch(PDOException $e)
            {
              echo($e->getMessage());
            }
          }

          if ($this->_city)
          {
            if (Input::get('city') == "Johannesburg")
            {
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeJhb'),
                        'longitude' => Config::get('cities/LongitudeJhb')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') == "Durban")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeDbn'),
                        'longitude' => Config::get('cities/LongitudeDbn')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') === "Cape Town")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeCpt'),
                        'longitude' => Config::get('cities/LongitudeCpt')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') == "Pretoria")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudePta'),
                        'longitude' => Config::get('cities/LongitudePta')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') == "Rustenburg")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeRtn'),
                        'longitude' => Config::get('cities/LongitudeRtn')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') === "Port Elizabeth")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudePE'),
                        'longitude' => Config::get('cities/LongitudePE')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') == "Nelspruit")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeNsp'),
                        'longitude' => Config::get('cities/LongitudeNsp')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') === "Bloemfontain")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudeBlm'),
                        'longitude' => Config::get('cities/LongitudeBlm')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else if (Input::get('city') === "Polokwane")
            {
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/LatitudePlk'),
                        'longitude' => Config::get('cities/LongitudePlk')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }else{
                
                try{
                    DB::getInstance()->update('users', $this->_user->data()->id , array(
                        'latitude' => Config::get('cities/Latitude'),
                        'longitude' => Config::get('cities/Longitude')
                    ));
                    echo '<p>Your City Has been Successfully Updated...</p>';
                }catch(PDOException $e)
                {
                    echo($e->getMessage());
                }
            }
          }
    }

    public function addRange($min , $max)
    {
      $user = $this->_user;
      $uid = $user->data()->id;
      if ($user)
      {
            try{
                $interests = DB::getInstance()->update('interests', $uid , array(
                    'min' => $min,
                    'max' => $max
                    ), "user_id");
                if ($interests)
                {
                    echo "Updated Njenna";
                    return(true);
                }else{
                    return (false);
                }
            }catch(PDOException $e)
            {
                echo($e->getMessage());
            }
        }
    }

    public function interest($id, $field, $val = NULL)
    {
      $user = $this->_user;
      $uid = $id;
      $value = ($val == NULL) ? 1 : $val;
      if ($user)
      {
          $interests = DB::getInstance()->get('interests', array('user_id', '=' , $uid));
          if ($interests->count())
          {
              $i = 0;
              foreach($interests->first() as $keys => $item)
              {
                if ($keys !== 'id' && $keys !== 'user_id' && $item == 1 && $keys !== 'gender' && $keys !== 'max' && $keys !== 'min')
                {
                    $i++;
                }
              }
              if ($i < 5 || $field == "gender"){
                  try{
                      $interests = DB::getInstance()->update('interests', $id , array(
                          "`$field`" => $value
                        ), "user_id");
                        if ($interests)
                        {
                            echo "Updated Njenna";
                        }
                    }catch(PDOException $e)
                    {
                        echo($e->getMessage());
                    }
                
                }else{
                    echo '<script language="javascript">';
                    echo 'alert("You Can Only Have 5 Interests!")';
                    echo '</script>';
                    return(false);
                }
          }
          else{
              try{
              $interests = DB::getInstance()->insert('interests', array(
                  'user_id' => $uid,
                  $field => $value
              ));
              }catch(PDOException $e)
              {
                  echo($e->getMessage());
              }
          }
      }
    }

    public  function upload()
    {
        $path = "img/avatar/". $this->_user->data()->username . "-dp/";
        if (!file_exists($path))
            mkdir($path, 0777, true);
        $filename = $_FILES['avatar']['name'];
        $path = $path."{$filename}";
        $tmp_name = $_FILES['avatar']['tmp_name'];
        if($this->validate($path)) {
            if(move_uploaded_file($tmp_name, $path)) {
                try{

                    DB::getInstance()->update('users', $this->_user->data()->id, array(
                        'avatar' => $path
                    ));

                     return (true);
                }catch (PDOException $e){
                    echo "{$e->getMessage()}<br>";
                }
            }
            else {
                return (false);
            }
        }else{
            foreach ($this->error() as $err)
                echo "$err <br>";
            return (false);
        }
    }

    public  function upload_pics()
    {
        $path_images = DB::getInstance()->get('users',array('id', '=', $this->_user->data()->id));
        $images = $path_images->first()->images;
        $path = "img/user/". $this->_user->data()->username . "-img/";
        if (!file_exists($path))
            mkdir($path, 0777, true);
        $filename = $_FILES['five_image']['name'];
        $path = $path."{$filename}";
        $tmp_name = $_FILES['five_image']['tmp_name'];
        if ($images)
        {
            $images = unserialize($images);
            if (count($images) < 5)
            {
                $images[] = array(
                    'img' => $path,
                    'filename' => $filename
                );
            }else {
                echo '<script language="javascript">';
                echo 'alert("You Can Only Upload 5 Images!")';
                echo '</script>';
                return (false);
            }
            $images = serialize($images);
        }else{
            $image = array();
            $image[] = array(
                'img' => $path,
                'filename' => $filename
            );
            $images = serialize($image);
        }
        if($this->validate($path)) {
            if(move_uploaded_file($tmp_name, $path)) {
                try{

                    DB::getInstance()->update('users', $this->_user->data()->id, array(
                        'images' => $images
                    ));

                     return (true);
                }catch (PDOException $e){
                    echo "{$e->getMessage()}<br>";
                }
            }
            else {
                return (false);
            }
        }else{
            foreach ($this->error() as $err)
                echo "$err <br>";
            return (false);
        }
    }

    private function addError($error)
    {
        $this->_error[] = $error;
    }

    public function passed()
    {
        return ($this->_passed);
    }

    public function error()
    {
        return ($this->_error);
    }

    private function valid($targetFile)
    {
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $fileName = $_FILES['avatar']['size'];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (file_exists($targetFile))
        {
            $this->addError("{$fileName} Already exists");
        }
        if ($fileSize > 5000000 || $fileSize == 0)
        {
            if ($_FILES['isthombe']['size'] > 5000000)
                $this->addError("{$fileName} File of {$fileSize} bytes is Too Large for Upload");
            else
                $this->addError("{$fileName} Cannot push empty files or {$fileSize} byte files");
        }
        if ($fileType !== 'jpg' && $fileType !== 'jpeg' && $fileType !== 'gif' && $fileType !== 'png')
        {
            $this->addError("Unknown file Type {$fileName}");
        }
        if (empty($this->_error)){
            return (true);
        }
        else
            return (false);
    }
}


?>