<?php

class Match
{
    private     $_user,
    $filter,
    $_db,
    $_sort,
    $_result;
    
    
    public  function __construct($id = NULL)
    {
        $this->_db = DB::getInstance();
        $this->_user = new User($id);
    }

    public function sort_users($flag, $by)
    {
        $interest = $this->_db->get('interests', array('user_id', '=', $this->_user->data()->id));
        if ($interest->count())
        {
            $gender = $interest->first()->gender;
            $minAge = $interest->first()->min;
            $maxAge = $interest->first()->max;
            if ($gender == 0)
            {
                if ($flag == 'age' || $flag == "rating")
                {
                    $by = ($by == "Ascending") ? "ASC" : "DESC";
                    if ($maxAge && $minAge)
                    {
                        $flag = ($flag == "age") ? "age" : "visits";
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 0 AND `age` > {$minAge} AND `age` < {$maxAge}  ORDER BY `{$flag}` ".$by);
                    }else{
                        $flag = ($flag == "age") ? "age" : "visits";
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 0 ORDER BY `{$flag}` ".$by);
                    }
                }else if ($flag == 'interests' || $flag == "location")
                {
                    if ($flag == "location")
                    {
                        $longitude = $this->_user->data()->longitude;
                        $latitude = $this->_user->data()->latitude;
                        if ($by == "Near - Far")
                        {
                            $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` =  0 AND `longitude` = {$longitude} AND `latitude` = {$latitude}");
                        }else{
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` =  0 AND `latitude` <> {$latitude}");
                        }
                    }else{
                        $myinterest = array();
                        $i = 0;
                        foreach($interest->first() as $key => $intr)
                        {
                            if (($key !== 'gender' || $key !== 'id' || $key !== 'user_id' || $key !== 'max' || $key !== 'min' || $key !== 'gender') && $intr == 1)
                            {
                                $myinterest[$i] = $key;
                                $i++;
                            }
                        }
                        if ($by == "Most")
                        {
                            $query = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE (`users`.`group` <> 1 AND `users`.`id` <> {$this->_user->data()->id}) AND (`$myinterest[0]` = 1 AND `$myinterest[1]` = 1 AND `$myinterest[2]` = 1 OR `$myinterest[3]` = 1 AND `$myinterest[4]` = 1) AND `users`.`gender` = 0";
                        }else{
                            $query = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE (`users`.`group` <> 1 AND `users`.`id` <> {$this->_user->data()->id}) AND (`$myinterest[0]` = 1 OR `$myinterest[1]` = 1 OR `$myinterest[2]` = 1 OR `$myinterest[3]` = 1 OR `$myinterest[4]` = 1)";
                        }
                        $people = $this->_db->query($query);
                    }
                }
            }
            else if ($gender == 1)
            {
                if ($flag == 'age' || $flag == "rating")
                {
                    $by = ($by == "Ascending") ? "ASC" : "DESC";
                    if ($minAge && $maxAge)
                    {
                        $flag = ($flag == "age") ? "age" : "visits";
                       $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 1 AND `age` > {$minAge} AND `age` < {$maxAge} ORDER BY {$flag} {$by}");
                    }else{
                        $flag = ($flag == "age") ? "age" : "visits";
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 1 ORDER BY {$flag} {$by}");
                    }
                }else if ($flag == "interests" || $flag == "location")
                {
                    if ($flag == "location")
                    {
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` =  0 ORDER BY `longitude`");
                    }else{
                        $people = $this->_db->query("SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1");
                    }
                }
            }
            else
            {
                if ($flag == 'age' || $flag == "rating")
                {
                    $by = ($by == "Ascending") ? "ASC" : "DESC";
                    $flag = ($flag == "age") ? "age" : "visits";
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} ORDER BY {$flag} {$by}");
                }else if ($flag == "interests" || $flag == "location")
                {
                    if ($flag == "location")
                    {
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` =  0");
                    }else{
                        die("here");
                        $people = $this->_db->query("SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1");
                    }
                }
            }
        }else{
            if ($flag == "age" || $flag == "rating")
            {
                $by = ($by == "Ascending") ? "ASC" : "DESC";
                $flag = ($flag == "age") ? "age" : "visits";
                $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} ORDER BY {$flag} {$by}");
            }else if ($flag == "location" || $flag == "interests")
            {
                if ($flag == "location")
                {
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` =  0");
                }else{
                    $people = $this->_db->query("SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE`group` <> 1");
                }
            }
        }
        $this->result = $people;
        return ($people);
    }


    public function filter_users($flag, $by)
    {
        if ($flag == "age")
        {
            $byMin = substr($by, 0, 2);
            $byMax = ($byMin == 55) ? 100 : substr($by, 5, 2);
        }
        $interest = $this->_db->get('interests', array('user_id', '=', $this->_user->data()->id));
        if ($interest->count())
        {
            $gender = $interest->first()->gender;
            $minAge = $interest->first()->min;
            $maxAge = $interest->first()->max;
            if ($gender == 0)
            {
                if ($flag == "age" || $flag == "rating")
                {
                    $flag = ($flag == "age") ? "age" : "ratings";
                    if ($flag == "age")
                    {
                        $sql = "SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 0 AND (`age` > {$byMin} AND `age` < {$byMax})";
                        $people = $this->_db->query($sql);
                    }else{
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND `gender` = 0 AND (cast(`{$flag}` as decimal(65,0)) = {$by})");
                    }
                }else if ($flag = "interests")
                {
                    $sql = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1 AND `user_id` <> {$this->_user->data()->id} AND {$by} = 1 AND `users`.`gender` = 0";
                    $people = $this->_db->query($sql);
                }else{
                    $bythis = substr($by, 5, 2);
                    $bythis = ($bythis == "&l") ? 1000 : $bythis;
                    $query = "SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND  `gender` = 0 AND `longitude` < {$this->_user->data()->longitude} + {$bythis}";
                    $people = $this->_db->query($query);
                }
            }else if ($gender == 1)
            {
                if ($flag == "age" || $flag == "rating")
                {
                    $flag = ($flag == "age") ? "age" : "ratings";
                    if ($flag == "age")
                    {
                        $sql = "SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND  `gender` = 1 AND (`age` > {$byMin} AND `age` < {$byMax})";
                        $people = $this->_db->query($sql);
                    }else{
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND  `gender` = 1 AND (cast(`{$flag}` as decimal(65,0)) = {$by})");
                    }
                }else if ($flag == "interests")
                {
                    $sql = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1 AND `user_id` <> {$this->_user->data()->id} AND  {$by} = 1 AND `users`.`gender` = 1";
                    $people = $this->_db->query($sql);
                }else{
                    $bythis = substr($by, 5, 2);
                    $bythis = ($bythis == "&l") ? 1000 : $bythis;
                    $query = "SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND  `gender` = 1 AND `longitude` < {$this->_user->data()->longitude} + {$bythis}";
                    $people = $this->_db->query($query);
                }

            }else{
                if ($flag == "age" || $flag == "rating")
                {
                    $flag = ($flag == "age") ? "age" : "ratings";
                    if ($flag == "age")
                    {
                        $sql = "SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND (`age` > {$byMin} AND `age` < {$byMax})";
                        $people = $this->_db->query($sql);
                    }else{
                        $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND (cast(`{$flag}` as decimal(65,0)) = {$by})");
                    }
                }else if ($flag = "interests")
                {
                    $sql = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1 AND `user_id` <> {$this->_user->data()->id} AND  {$by} = 1 AND `id` <> {$this->_user->data()->id}";
                    $people = $this->_db->query($sql);
                }else{
                    $bythis = substr($by, 5, 2);
                    $bythis = ($bythis == "&l") ? 1000 : $bythis;
                    $query = "SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND `longitude` < {$this->_user->data()->longitude} + {$bythis}";
                    $people = $this->_db->query($query);
                }
            }
        }else{
            if ($flag == "age" || $flag == "rating")
            {
                $flag = ($flag == "age") ? "age" : "ratings";
                if ($flag == "age")
                {
                    $sql = "SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND (`age` > {$byMin} AND `age` < {$byMax})";
                    $people = $this->_db->query($sql);
                }else{
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id} AND (cast(`{$flag}` as decimal(5,1)) = {$by})");
                }
            }else if ($flag = "interests")
            {
                $sql = "SELECT * FROM `users` INNER JOIN `interests` ON `users`.`id`=`interests`.`user_id` WHERE `group` <> 1 AND `user_id` <> {$this->_user->data()->id} AND ({$by} = 1 AND `users`.`gender` = 0)";
                $people = $this->_db->query($sql);
            }else{
                $bythis = substr($by, 5, 2);
                $bythis = ($bythis == "&l") ? 1000 : $bythis;
                $query = "SELECT * FROM `users` WHERE `id` <> {$this->_user->data()->id} AND  `gender` = 1 AND `longitude` < {$this->_user->data()->longitude} + {$bythis}";
                $people = $this->_db->query($query);
            }
        }
        $this->result = $people;
        return ($people);
    }


    public  function result()
    {
        return ($this->_result);
    }

    public function match_user()
    {
        $interest = $this->_db->get('interests', array('user_id', '=', $this->_user->data()->id));
        if ($interest->count())
        {
            $gender = $interest->first()->gender;
            $minAge = $interest->first()->min;
            $maxAge = $interest->first()->max;
            if ($gender == 0)
            {
                if ($minAge && $maxAge)
                {
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `gender` = 0 AND `age` > {$minAge} AND `age` < {$maxAge} AND `id` <> {$this->_user->data()->id}");    
                }else{
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `gender` = 0 AND `id` <> {$this->_user->data()->id}");
                }
            }
            else if ($gender == 1)
            {
                if ($maxAge && $minAge)
                {
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `gender` = 1 AND `age` > {$minAge} AND `age` < {$maxAge} AND `id` <> {$this->_user->data()->id}");    
                }else{
                    $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `gender` = 1 AND `id` <> {$this->_user->data()->id}");
                }
            }
            else if ($gender == 2)
            {
                $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id}");
            }
        }else{
            $people = $this->_db->query("SELECT * FROM `users` WHERE `group` <> 1 AND `id` <> {$this->_user->data()->id}");
        }
        $this->result = $people;
        return ($people);
    }
}

?>