<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 11/6/2018
 * Time: 5:25 PM
 */

class User
{
    private $_db,
            $_data,
            $_cookieName,
            $_sessioName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
        $this->_cookieName = Config::get('remember/cookie_name');
        $this->_sessioName = Config::get('session/session_name');

        if (!$user)
        {
            if (Session::exists($this->_sessioName))
            {
                $user = Session::get($this->_sessioName);
                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
                else
                {
                    $this->logOut();
                }
            }
        }else
        {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields))
        {
            throw new PDOException("Error Creating user account please try again");
        }
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field = (is_numeric($user) ? 'id' : 'username');
            $data = $this->_db->get('users', array($field, '=' ,$user));
            if ($data->count())
            {
                $this->_data = $data->first();
                return (true);
            }
        }
        return (false);
    }

    public function login($username = null, $password = null, $remember = false)
    {
        $hash = Hash::unique();
        if (!$username && !$password && $this->exists())
        {
            Session::set($this->_sessioName, $this->_data->id);
        }
        else{
            $user = $this->find($username);
            if ($user)
            {
                if($this->data()->password === Hash::make($password, $this->data()->salt))
                {
                    Session::set($this->_sessioName, $this->data()->id);
                    if ($remember)
                    {
                        $hashCheck = $this->_db->get('user_session', array('user_id', '=', $this->data()->id));
                        if (!$hashCheck->count())
                        {
                            $this->_db->insert('user_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        }
                        else{
                            $hash = $hashCheck->first()->hash;
                        }
                        Session::set($this->_sessioName, $this->data()->id, Config::get('remember/cookie_exp'));
                    }
                    $this->_db->insert('user_session', array(
                        'user_id' => $this->data()->id,
                        'hash' => $hash
                    ));
                    return (true);
                }
            }
        }
        return (false);
    }

    public function data()
    {
        return ($this->_data);
    }

    public function exists()
    {
        return((!empty($this->data())) ? true : false);
    }

    public function update($fields = array(), $user = null)
    {
        if (!$user && $this->isLoggedIn())
        {
            $user = $this->data()->id;
        }

        if (!$this->_db->update('users', $user, $fields))
        {
            throw new PDOException('There Was An Error Updating Profile PLease Try Again...');
        }
    }

    public function isLoggedIn()
    {
        return ($this->_isLoggedIn);
    }

    public function logOut()
    {
        if ($this->isLoggedIn())
        {
            $this->_db->delete('user_session', array('user_id', '=', $this->data()->id));
            Session::delete($this->_sessioName);
            Cookie::delete($this->_cookieName);
        }
    }

    public function IsSuperUser($key)
    {
        $group = $this->_db->get('group', array('id', '=', $this->data()-group));
        if ($group->count())
        {
            $permission = json_decode($group->first()->permission);
            if ($permission[$key] == true)
            {
                return (true);
            }
        }
        return (false);
    }
}
