<?php

require_once 'database.php';

function createDb()
{
    try{
        $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo) {
            $sql = "DROP DATABASE IF EXISTS `" .database('mysql/database'). "`;";
            $dropped = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
            if ($dropped)
            {
                $sql = "CREATE DATABASE IF NOT EXISTS `db_matcha` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                $created = $pdo->query($sql);
            }
            if ($created) {
                $pdo->query("USE ".database('mysql/database'), PDO::ERRMODE_EXCEPTION);
                unset($pdo);
                return (true);
            }
            else
            {
                foreach ($pdo->errorInfo() as $key => $value)
                    echo "{$key} => {$value}<br>";
                unset($pdo);
                return (false);
            }
        }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}

function createTableGroup()
{
    try{
        $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo) {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`group`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS `". database('mysql/database') ."`.`group` (
                            `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `name` VARCHAR(20) NOT NULL,
                            `permission` TEXT NOT NULL)
                            CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB";
                $created = $pdo->query($sql,PDO::ERRMODE_EXCEPTION);
            }else{
                die($pdo->error_get_last());
            }
            if ($created) {
                $sql = "INSERT INTO `". database('mysql/database') ."`.`group` (
                        `id`,`name`,`permission`)
                        VALUES (
                        NULL, 'Administrator', '{\"Admin:\" 1}'
                        )";
                $pdo->query($sql);
                unset($pdo);
                return (true);
            }
        }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}

function createTableNotifications()
{
    try{
        $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo) {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`notifications`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS `". database('mysql/database') ."`.`notifications` (
                            `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `user_id` INT(11) NOT NULL,
                            `notifier_id` INT(11) NOT NULL,
                            `name` VARCHAR(20) NOT NULL,
                            `avatar` TEXT NOT NULL,
                            `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `notification` VARCHAR(128) NOT NULL,
                            KEY `FK` (`user_id`))
                            CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB";
                $created = $pdo->query($sql,PDO::ERRMODE_EXCEPTION);
            }
            if ($created) {
                unset($pdo);
                return (true);
            }
        }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}


function createTableMates()
{
    try{
        $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo) {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`mates`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS `". database('mysql/database') ."`.`mates` (
                            `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `reqID` INT  NOT NULL,
                            `provID` INT  NOT NULL,
                            `accepted` INT  NOT NULL,
                            KEY `FK` (`reqID`,`provID`))
                            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB";
                $created = $pdo->query($sql,PDO::ERRMODE_EXCEPTION);
            }
            if ($created) {
                unset($pdo);
                return (true);
            }
        }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}

function createTableUsers()
{
    try{
            $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($pdo) {
                $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`users`;";
                $dropped = $pdo->query($sql);
                if ($dropped)
                {
                    $sql = "CREATE TABLE IF NOT EXISTS`". database('mysql/database') ."`.`users` ( 
                                    `id` INT NOT NULL AUTO_INCREMENT ,
                                    `username` VARCHAR(20) NOT NULL ,
                                    `fullname` VARCHAR(50) NOT NULL ,
                                    `gender` TINYINT(1) ,
                                    `email` VARCHAR(32) NOT NULL ,
                                    `about` VARCHAR(256) NOT NULL,
                                    `avatar` VARCHAR(64) ,
                                    `images` TEXT,
                                    `age` INT NOT NULL,
                                    `location` VARCHAR(128) NOT NULL,
                                    `latitude` VARCHAR(16) NOT NULL,
                                    `longitude` VARCHAR(16) NOT NULL,
                                    `password` VARCHAR(64) NOT NULL ,
                                    `salt` VARCHAR(32) NOT NULL ,
                                    `code` INT NOT NULL ,
                                    `joined` TIMESTAMP NOT NULL DEFAULT  CURRENT_TIMESTAMP,
                                    `notify` TINYINT(1) NOT NULL,
                                    `active` TINYINT(1) NOT NULL ,
                                    `group` TINYINT(1) NOT NULL ,
                                    `visits` INT NOT NULL ,
                                    `visitors` TEXT DEFAULT NULL,
                                    `ratings` FLOAT NOT NULL DEFAULT 0.0,
                                    `notifications` TEXT DEFAULT NULL,
                                    PRIMARY KEY (`id`))
                                    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB";
                    $created = $pdo->query($sql);
                }
                if ($created) {
                    unset($pdo);
                    return (true);
                }
            }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}

function createTableUsersSessions()
{
    try{
        $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo) {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`user_session`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS`". database('mysql/database') ."`.`user_session` (
                            `id` INT NOT NULL AUTO_INCREMENT ,
                            `user_id` INT NOT NULL ,
                            `hash` VARCHAR(64) NOT NULL ,
                            `last_seen` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`),
                            KEY `FK` (`user_id`))
                            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB";
                $created = $pdo->query($sql,PDO::ERRMODE_EXCEPTION);
            }
            if ($created) {
                unset($pdo);
                return (true);
            }
        }
    }catch(PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
}

function createTableChats()
{
    try{
        $pdo = new  PDO(database('mysql/dsn'), database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo)
        {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`chats`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS `". database('mysql/database') ."`.`chats` (
                            `chatID` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            `fromID` INT  NOT NULL ,
                            `toID` INT  NOT NULL ,
                            `sendDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `message` TEXT NOT NULL,
                            KEY `FK` (`toID`, `fromID`)
                            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = innoDB";
    
                $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
            }
            if ($created)
            {
                unset($pdo);
                return (true);
            }
        }
    }catch (PDOException $e){
        throw new pdoException($e->getMessage(), $e->getCode());
    }
}

function createTableInterests(){
    try{
        $pdo = new  PDO(database('mysql/dsn'), database('mysql/username'), database('mysql/password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($pdo)
        {
            $sql = "DROP TABLE IF EXISTS `". database('mysql/database') ."`.`interests`;";
            $dropped = $pdo->query($sql);
            if ($dropped)
            {
                $sql = "CREATE TABLE IF NOT EXISTS `". database('mysql/database') ."`.`interests` (
                            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            `user_id` INT NOT NULL ,
                            `gender` INT DEFAULT NULL,
                            `travelling` INT  DEFAULT NULL ,
                            `exercising` INT DEFAULT NULL ,
                            `theater` INT DEFAULT NULL,
                            `dancing` INT DEFAULT NULL,
                            `cooking` INT DEFAULT NULL,
                            `outdoors` INT DEFAULT NULL,
                            `politics` INT DEFAULT NULL,
                            `pets` INT  DEFAULT NULL,
                            `photography` INT DEFAULT NULL,
                            `sports` INT DEFAULT NULL,
                            `music` INT DEFAULT NULL,
                            `books` INT DEFAULT NULL,
                            `movies` INT DEFAULT NULL,
                            `games` INT DEFAULT NULL,
                            `indoors` INT DEFAULT NULL,
                            `poetry` INT DEFAULT NULL,
                            `min` INT DEFAULT NULL,
                            `max` INT DEFAULT NULL,
                            KEY `FK` (`user_id`)
                            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = innoDB";
                $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
            }
            if ($created)
            {
                unset($pdo);
                return (true);
            }
        }
    }catch (PDOException $e){
        throw new pdoException($e->getMessage(), $e->getCode());
    }
}

try {

    if (createDb())
        echo '<h3 style="color: green;">Database Created Successfully<br></h3>';
    else
        echo '<h3 style="color: red;">Error Creating Database</h3>';

    if (createTableGroup()){
        echo '<h3 style="color: green;">Table group Created Successfully<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Group<br></h3>';
    }


    if (createTableUsers()){
        echo '<h3 style="color: green;">Error Table Users Created Successfully<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Users</h3>';
    }

    if (createTableUsersSessions()){
        echo '<h3 style="color: green;">Table user_sessions Created Successfully<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table user_sessions<br></h3>';
    }


    if (createTableMates()){
        echo '<h3 style="color: green;">Table Mates successfully created<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Mates<br></h3>';
    }

    if (createTableChats()){
        echo '<h3 style="color: green;">Table Chats successfully created<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Chats<br></h3>';
    }

    if (createTableInterests()){
        echo '<h3 style="color: green;">Table Interests successfully created<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Interests<br></h3>';
    }

    if (createTableNotifications()){
        echo '<h3 style="color: green;">Table Notifications successfully created<br></h3>';
    }
    else{
        echo '<h3 style="color: red;">Error Creating Table Notifications<br></h3>';
    }

    $pdo = new PDO(database('mysql/dsn'),database('mysql/username'), database('mysql/password'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $salt = salt("saltingsasfarassaltsgo!@#$%^&*()");
    $password = make('notadmin',$salt);
    $t_stamp = date('Y-m-d H:i:s');
    $location = "84 Albertina Sisulu Rd, Johannesburg, 2000";
    $longitudeJhb = '28.034088';
    $latitudeJhb = '-26.195246';
    $latitudeCpt = '-33.918861';
    $longitudeCpt = '18.423300';
    $latitudePta = '-25.731340';
    $longitudePta = '28.218370';
    $latitudeDbn = '-29.8579006';
    $longitudeDbn = '31.0291996';
    try {
        if ($pdo) {
            $sql = "INSERT INTO `". database('mysql/database') ."`.`users`(
                `id`, `username`, `fullname`, `gender`, `email`, `about`, `avatar`, `age`, `location`, `latitude`,`longitude`,`password`, `salt`, `code`, `joined`, `notify`, `active`, `group`, `visits`) 
                VALUES (NULL,'banele','Banele Mabe','1','banelemabe@matcha.com','Admins do not need a bio, need to enquier? email me on my email address','img/bg/account-blue.png','21','$location','$latitudeJhb','$longitudeJhb','$password','$salt','46841','$t_stamp','0','1','1', '0');";

            $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
            if (!$created) {
                echo '<h3 style="color: red;">Error Creating Admin User<br></h3>';
            }
            else{
                echo '<h3 style="color: green;">Admin account successfully created<br></h3>';
            }
        }
    }catch (PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }


    try {
        if ($pdo) {
            $sql = "INSERT INTO `". database('mysql/database') ."`.`users`(
                `id`, `username`, `fullname`, `gender`, `email`, `about`, `avatar`, `age`, `location`, `latitude`,`longitude`,`password`, `salt`, `code`, `joined`, `notify`, `active`, `group`, `visits`) 
                VALUES (NULL,'Nkuli','Nkuli Macgestar','1','macgestar@matcha.com','Admins do not need a bio, need to enquier? email me on my email address','img/bg/account-blue.png','27','$location','$latitudeJhb','$longitudeJhb','$password','$salt','46842','$t_stamp','0','1','1', '0');";

            $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
            if (!$created) {
                echo '<h3 style="color: red;">Error Creating Admin User<br></h3>';
            }
            else{
                echo '<h3 style="color: green;">Admin account successfully created<br></h3>';
            }
        }
    }catch (PDOException $e)
    {
        throw new pdoException($e->getMessage(), (int)$e->getCode());
    }
} catch (Exception $e)
{
    die($e->getMessage());
}

try {
    if ($pdo) {
        $sql = "INSERT INTO `". database('mysql/database') ."`.`users`(
            `id`, `username`, `fullname`, `gender`, `email`, `about`, `avatar`, `age`, `location`, `latitude`,`longitude`,`password`, `salt`, `code`, `joined`, `notify`, `active`, `group`, `visits`) 
            VALUES (NULL,'Thato','Thato Thato','0','tthato@matcha.com','Admins do not need a bio, need to enquier? email me on my email address', 'img/bg/account-blue.png','25','$location','$latitudeJhb','$longitudeJhb','$password','$salt','46841','$t_stamp','0','1','1', '0');";

        $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
        if (!$created) {
            echo '<h3 style="color: red;">Error Creating Admin User<br></h3>';
        }
        else{
            echo '<h3 style="color: green;">Admin account successfully created<br></h3>';
        }
    }
}catch (PDOException $e)
{
    throw new pdoException($e->getMessage(), (int)$e->getCode());
}

try {
    if ($pdo) {
        $sql = "INSERT INTO `". database('mysql/database') ."`.`users`(
            `id`, `username`, `fullname`, `gender`, `email`, `about`, `avatar`, `age`, `location`, `latitude`,`longitude`,`password`, `salt`, `code`, `joined`, `notify`, `active`, `group`, `visits`, `ratings`) 
            VALUES (
                NULL, 
                'drstrange',
                'Strange Stephen', 
                '1',
                'drstrange@mailinator.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '30',
                '15-3 Strelitzia St, Cresta, Randburg, 2118',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '12345',
                '$t_stamp',
                '1',
                '1',
                '0',
                '10',
                '0.102'    
            ),
            (
                NULL,
                'lumpys',
                'Princess Lumpy Space',
                '0',
                'lumpyspace@mailinator.com',
                'Such an oddball!',
                'img/bg/account-green.png',
                '18',
                '36 Olive Rd, Olivedale, Randburg, 2188',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2 ',
                '20117',
                '2018-11-28 2:32:01',
                '1',
                '1',
                '0',
                '26',
                '1.03'
            ),
        (
                NULL,
                'lectus',
                'Swanson Colleen',
                '0',
                'lectus.convallis@mailinator.com',
                'Bored housewife...not getting any younger!',
                'img/bg/account-blue.png',
                '47',
                '12124 Segotsane St, Diepkloof, Gauteng',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2 ',
                '59049',
                '2017-10-09 2:23:21',
                '1',
                '1',
                '0',
                '33',
                '1.52'
            ),
        (
                NULL,
                'Murraysins',
                'Murray Madison',
                '1',
                'Nuncsed.orci@mailinator.com',
                'God & Hard Work NASM CPT CFSC Pn1 Nutrition Coach Trainer @scottsdalebodi Owner Coach @ MadFit Published Fitness Model Former NBA Dancer-Jazz & Suns',
                'img/bg/account-blue.png',
                '21',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '$t_stamp',
                '1',
                '1',
                '0',
                '29',
                '1.333'),
        (
                NULL,
                'Muzi',
                'Muzi Hlophe',
                '1',
                'mmlhope.orci@mailinator.com',
                'God & Hard Work\r\nNASM CPT, CFSC\r\nPn1 Nutrition Coach\r\nTrainer @scottsdalebodi\r\nOwner/Coach @ MadFit\r\nPublished Fitness Model\r\nFormer NBA Dancer-Jazz & Suns',
                'img/bg/account-green.png',
                '31',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2 ',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '16',
                '0.12'),
        (   
                NULL,
                'Nickson',
                'Nickson Brailey',
                '1',
                'nbrailey@gmail.com',
                'God & Hard Work\r\nNASM CPT, CFSC\r\nPn1 Nutrition Coach\r\nTrainer @scottsdalebodi\r\nOwner/Coach @ MadFit\r\nPublished Fitness Model\r\nFormer NBA Dancer-Jazz & Suns',
                'img/bg/account-green.png',
                '31',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2 ',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '13',
                '0.662'),
        (
                NULL,
                'Neo',
                'Neo Mohajana',
                '1',
                'nmohaj@mailinator.com',
                'Yes i took my wife''s surname and i still use it after our devorce sow what?!',
                'img/bg/account-blue.png',
                '37',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '46',
                '2.3'),
        (
                NULL,
                'Lerato',
                'Lerato Ntotsohle',
                '0',
                'leverything@gmail.com',
                'Criminal defense attorney. 1/508th A.B.C.T....I see that Christian is the lede of your bio. Should I lead mine with agnostic? I''m unsure.',
                'img/bg/account-blue.png',
                '31',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2 ',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '86',
                '4.3'
            ),
        (
                NULL,
                'Kobus',
                'Kobus Van Brandis',
                '1',
                'kvb@gmail.com',
                'Kobus is my naam monie kom yi and bekley nie yiso',
                'img/bg/account-green.png',
                '46',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '5',
                '0.253'),
        (
                NULL,
                'Patrice',
                'Pritrice Dikeledi Mohajane',
                '0',
                'pdmohaj@gmail.com',
                'Sylvester J. Pussycat Sr.\, usually called Sylvester, is a fictional character, a three-time Academy Award-winning anthropomorphic, 40, 50, or 60-Inch tall Tuxedo cat in the Looney Tunes and Merrie Melodies series of cartoons',
                'img/bg/account-green.png',
                '26',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '46',
                '2.3'),
        (
                NULL,
                'Lefty',
                'Lefty Masemola',
                '1',
                'lefty@gmail.com',
                'Todd C. Chapman is a career United States Foreign Service officer and current United States Ambassador to Ecuador.  He is a diplomat with more than 25 years of experience in the foreign service.',
                'img/bg/account-green.png',
                '36',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '21',
                '1.05'),
        (
                NULL,
                'Kelly',
                'Kelly Stuurman',
                '1',
                'kst@gmail.com',
                'I know what my name sounds like but believe me, I am not some rich, white boy from the suburbs.',
                'img/bg/account-green.png',
                '24',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2', 
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '13',
                '0.5'),
        (
                NULL,
                'Penny',
                'Penny Gratis',
                '0',
                'wgratis@gmail.com',
                'I am a mother of two but that does not define me!',
                'img/bg/account-green.png',
                '27',
                '5655-5663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '63',
                '3.015'),
        (
                NULL,
                'Nhlanhla',
                'Nhlanhla Gumede',
                '1',
                'ngumede@gmail.com',
                'Fabulous Durbanites UNITE!',
                'img/bg/account-green.png',
                '24',
                'North Beach Durban 4063',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '66',
                '3.33'),
        (
                NULL,
                'katleho',
                'Katleho Ekalafeng',
                '1',
                'katleho@gmail.com',
                'DJ superstar! David Guetta got nothing on me!',
                'img/bg/account-green.png',
                '24',
                '243-263 O R Tambo Parade North Beach Durban 4063',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '54',
                '2.12'),
        (
                NULL,
                'Gregory',
                'Gregory Thebe',
                '1',
                'gthebe@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '29',
                '243-263 O R Tambo Parade North Beach Durban 4063',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '15',
                '0.525'),
        (
                NULL,
                'Xoli',
                'Xoli Sister X',
                '0',
                'sisterx@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '19',
                '78 Baumann Rd, North Beach, Durban, 4001',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '75',
                '3.25'),
        (
                NULL,
                'Dineo',
                'Dineo Matlhori',
                '0',
                'dini@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '49',
                'Mputhi St, Jabavu, Soweto, 1809',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '64',
                '3.2'),
        (
                NULL,
                'Emmanule',
                'Emmanuel Patra',
                '1',
                'emmanuelpatra@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '56',
                'Glenmarais Kempton Park 1619',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '50',
                '2.5'),
        (
                NULL,
                'Sonia',
                'Sonia Mbele',
                '0',
                'ibhele@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '29',
                '124-58 Tshabala St Emoyeni Tembisa',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '79',
                '3.88'),
        (
                NULL,
                'Thuli',
                'Thuli Sis Thuli',
                '0',
                'sisthuli@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '25',
                'Klippoortjie AH Germiston 1401',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '25',
                '1.25'
        ),
        (
                NULL,
                'Zinhle',
                'Zinhle Tyhulu',
                '0',
                'zee@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '22',
                '263 9th Ave Klippoortjie AH Cape Town 1401',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '25',
                '1.25'
        ),
        (
                NULL,
                'Mike',
                'Mike Teflon',
                '1',
                'mkteflon@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '34',
                '263 12th Street Sunny Side  Pretoria 1401',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2012-05-28 2:28:21',
                '1',
                '1',
                '0',
                '85',
                '4.25'
        ),
        (
                NULL,
                'Jack',
                'Jack Lickerson',
                '1',
                'jlickerson@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '22',
                '263 neon Street Highlands North Johannesburg 2001',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2018-05-28 2:28:21',
                '1',
                '1',
                '0',
                '15',
                '0.025'
        ),
        (
                NULL,
                'Peter',
                'Peter Daniels',
                '1',
                'pdanny@gmail.com',
                'Church Loving Individual who has kids and a dog wants to minggle and Jol!',
                'img/bg/account-green.png',
                '27',
                '263 Javis Street Cape Flats  Cape Town 1401',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2017-05-28 2:28:21',
                '1',
                '1',
                '0',
                '35',
                '1.125'
        ),
        (
                NULL,
                'Cherry',
                'Cherise Michaels',
                '0',
                'cherry99@gmail.com',
                'Tell me the Thruth and Ill let you in my life',
                'img/bg/account-green.png',
                '23',
                '263 Hightons Street Eldorado Park Johannesburg 1922',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Leon',
                'Leon Dale',
                '1',
                'leondale99@gmail.com',
                'Just and ordinary Dude with a big heart',
                'img/bg/account-green.png',
                '23',
                '263 Hights Street Gavin Park Pietermaritzburg 1922',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Jorja',
                'Jorja Deris',
                '0',
                'Jorja911@gmail.com',
                'Tenage Love Affair Thats what we all want',
                'img/bg/account-green.png',
                '23',
                '263 Klerk Street Springfield Pretorea 922',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '76',
                '3.35'
        ),
        (
                NULL,
                'Getty',
                'Getrude Getty Smith',
                '0',
                'getty@gmail.com',
                'Happy, Bubbly, Sparkle , People\'s Person and Party Starter',
                'img/bg/account-green.png',
                '20',
                '263 Honey Road Aukland Park Johannesburg 1922',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Sedwin',
                'Sedwin Mudau',
                '1',
                'smudau@gmail.com',
                'My life doesnt revolve around you',
                'img/bg/account-green.png',
                '33',
                '26 Gume Street Soshanguve Pretorea 1922',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'DJ Dolce',
                'Dolsen Makhubela',
                '1',
                'djdolce@gmail.com',
                'The dance floor is my play ground music is my game',
                'img/bg/account-green.png',
                '29',
                '63 Jubert Street Hillbrow Johannesburg 2002',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Brendon',
                'Brendon Zinne',
                '1',
                'bzinne99@gmail.com',
                'I do what i do just to get by, by any means neccessary',
                'img/bg/account-green.png',
                '31',
                '51 Halve Street Lenz Johannesburg 1833',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '55',
                '4.025'
        ),
        (
                NULL,
                'Chelsea',
                'Chelsea Mills',
                '0',
                'chelmills@gmail.com',
                'My Favorite Team is Chelsea FC is that a coincidence?',
                'img/bg/account-green.png',
                '23',
                '66 Caroltons Street Greenville Cape Town 1922',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '64',
                '3.022'
        ),
        (
                NULL,
                'Benny',
                'Benedict Nkosi',
                '1',
                'benny@gmail.com',
                'Kwazulu Natal Born and Bred, With cows and everything ready for lobola',
                'img/bg/account-green.png',
                '23',
                '26 Langa Street Mlazi Block D Durban 1922',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2012-05-28 2:28:21',
                '1',
                '1',
                '0',
                '35',
                '1.025'
        ),
        (
                NULL,
                'Cherry',
                'Cherise Michaels',
                '0',
                'cherry99@gmail.com',
                'Tell me the Thruth and Ill let you in my life',
                'img/bg/account-green.png',
                '23',
                '263 Hightons Street Eldorado Park Johannesburg 1922',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Jabu',
                'Jabu Mahlaba',
                '1',
                'jb@gmail.com',
                'Man that is lookng for a selfloving and god fearing woman',
                'img/bg/account-green.png',
                '23',
                '263 Lindokuhle Street Zone 7 Moletsane Soweto 1929',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2013-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Chester',
                'Chester Mdluli',
                '0',
                'ches@gmail.com',
                'Life Goes On, You Only Live Once',
                'img/bg/account-green.png',
                '28',
                '263 Thembu Street Thembisa Midrand 1922',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Jerry',
                'Jerry Mokoena',
                '1',
                'jerry@gmail.com',
                'Looking for a loving woman',
                'img/bg/account-green.png',
                '43',
                '263 Leteretere Street Palm Springs Johannesburg 2922',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Prince',
                'Prince Lihle Nduku',
                '1',
                'princenduku@gmail.com',
                'The prince of the zulu nation, born in a royal family of nquthu kwazulu natal',
                'img/bg/account-green.png',
                '23',
                '263 Hamisa Street Nquthu Kwazulu Natal 922',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Princess',
                'Princess Maduna',
                '0',
                'princess@gmail.com',
                'Ordinary Girl who loves dancing',
                'img/bg/account-green.png',
                '19',
                '63 Harrison Street Arcadia Pretoria 1922',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Edmond',
                'Edmond Ndlovu',
                '1',
                'edmondndlovu@gmail.com',
                'Edmond Ndlovu is a well known businessman from Soweto',
                'img/bg/account-green.png',
                '27',
                '4611 Mpane Street Phefeni 1966',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Frank',
                'Frank Bell',
                '1',
                'fbell@gmail.com',
                'Nothing beats the sound of jazz on sunday afternoon',
                'img/bg/account-green.png',
                '43',
                '113 Jason Drive Hamiltons Cape Town 922',
                '$latitudeCpt',
                '$longitudeCpt',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Ben',
                'Benjamin Ackermans',
                '1',
                'bacjermans@gmail.com',
                'Between Jobs And Heavy Metal Listner',
                'img/bg/account-green.png',
                '33',
                '2 East Lane Durban Kwazulu Natal 922',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Khanyi',
                'Khanyisile Ndlovu',
                '0',
                'kndlovu@gmail.com',
                'Everything in life comes to those that wait. Like my profile and make my day',
                'img/bg/account-green.png',
                '24',
                '23 Kenwood Street Turffontain Johannesburg Natal 922',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Jason',
                'Jason Mark Lasson',
                '1',
                'jml@gmail.com',
                'Done it all seen it all. Been There Done that Got the T-shirt',
                'img/bg/account-green.png',
                '73',
                '63 Hamilton Street Sunny Side Pretoria 92',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Patiance',
                'Paciance Hill',
                '0',
                'phill@gmail.com',
                'Doctor mother of the sweetest daughter and a hard worker',
                'img/bg/account-green.png',
                '29',
                '2622 Jordan Street Kenilworth Johannesburg 6558',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Joseph',
                'Joseph Palate',
                '1',
                'josephp@gmail.com',
                'Stricker for Orlando Pirates, Love evertyhing Sports, Sports Cars, Sports Ware, Sports etc ...',
                'img/bg/account-green.png',
                '26',
                '83 Cape Ave Honey Dew Johanesburg 2008',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Jazmine',
                'Jazmine Edwards',
                '0',
                'jazmine@gmail.com',
                'Likes being outdoors, the smell of nature and garden flowers',
                'img/bg/account-green.png',
                '38',
                '3 Jason Street Oliveson Durban 922',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Lihle',
                'Lihle Nkosi',
                '1',
                'nkosi@gmail.com',
                'Make Cakes during my spare time and baking is my passion',
                'img/bg/account-green.png',
                '22',
                '66 Mike Ave Selection Park Pretoria 7328',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Bongani',
                'Bongani Marabinyo',
                '1',
                'puyol@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '24',
                '263 Furnace Street Freedom Park Johannesburg 1822',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Scotch',
                'Scotch Pat Mahambula',
                '1',
                'scortch@gmail.com',
                'Scorth Never Dies, Die by Mistake',
                'img/bg/account-green.png',
                '73',
                '63 Fruitful Street Nodeville Durban 1922',
                '$latitudeDbn',
                '$longitudeDbn',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Kede',
                'Kedebone Sikhosana',
                '0',
                'sikhosanakediboni@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '27',
                '488 Siyabuswa A Pretoria 616',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Mbali',
                'Mbali Lyca Khumalo',
                '0',
                'lyca@gmail.com',
                'Poetry, Music, Musa, and Sfiso',
                'img/bg/account-green.png',
                '25',
                '28 Some Street Lawley East Johannesburg',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Nalingi',
                'Nalingi Iyoo',
                '0',
                'nalingiyoomama@gmail.com',
                'Radio Playlist Filler Makes songs for living',
                'img/bg/account-green.png',
                '19',
                '263 Hallsands Street Claton Park Pretoria 922',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Raymond',
                'Raymond Maraizor Khole',
                '1',
                'maraizor@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '42',
                '55 Dunis Street St Martins Johannesburg 1922',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Sthukzin',
                'Fphumulani Kevin Phundulu',
                '1',
                'fkp@gmail.com',
                'Sakatwani, Mrapper Kevin ... a man of many names known but many',
                'img/bg/account-green.png',
                '33',
                '263 Hamisa Street Springs Pretoria 9122',
                '$latitudePta',
                '$longitudePta',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        ),
        (
                NULL,
                'Sifiso',
                'Sifiso Sckarks Sikhakhane',
                '1',
                'sckarks@gmail.com',
                'This is a generic bio. One that I should probably change!',
                'img/bg/account-green.png',
                '28',
                '56663 Tloome St Orlando East Soweto 1804',
                '$latitudeJhb',
                '$longitudeJhb',
                'd1fe5572e96872fd2b3cfc551055d762a3b548c6a4a4e3d4f6e88e7e4d8e038b',
                '!*($^6%i#^*#n@8)&%&0sa(@5$!)tgl2',
                '36828',
                '2016-05-28 2:28:21',
                '1',
                '1',
                '0',
                '65',
                '3.025'
        );";


        // f@keacc0unt$

        $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
        if (!$created) {
            echo '<h3 style="color: red;">Error Creating Admin User<br></h3>';
        }
        else{
            echo '<h3 style="color: green;">Fake user accounts successfully created<br></h3>';
        }
    }
}catch (PDOException $e)
{
    throw new pdoException($e->getMessage(), (int)$e->getCode());
}


try{
    if($pdo)
    {
        $sql = "INSERT INTO ". database('mysql/database').".`interests` (`id`, `user_id`, `gender`, `travelling`, `exercising`, `theater`, `dancing`, `cooking`, `outdoors`, `politics`, `pets`, `photography`, `sports`, `music`, `books`, `movies`, `games`, `indoors`, `poetry`, `min`, `max`) 
        VALUES
        (NULL, '1', '2', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', '18', '25'),
        
        (NULL, '2', '0' , '1', NULL, NULL, NULL , NULL , '1', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', NULL, NULL),
        
        (NULL, '3', '1', NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, '1', '1', NULL, NULL, NULL, NULL, NULL),
        
        (NULL, '4', '2', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL, '1', NULL, '18', '28'),
        
        (NULL, '5', '1', NULL, NULL, '1', NULL, '1', NULL, '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '21', '30'),
        
        (NULL, '6', '1', '1', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, '50', '70'),
        
        (NULL, '7', '1', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', '18', '25'),
        
        (NULL, '8', '1', NULL, '1', '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', '21', '34'),
        
        (NULL, '9', '1', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, '1', NULL, '19', '30'),
        
        (NULL, '10', '1', NULL, NULL, NULL, '1', '1', NULL, '1', NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, '19', '36'),
        
        (NULL, '11', '1', NULL, NULL, NULL, '1', NULL, NULL, '1', '1', NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '30', '52'),
        
        (NULL, '12', '1', NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', '1', NULL, NULL, '21', '40'),
        
        (NULL, '13', '1', NULL, NULL, '1', '1', NULL, NULL, NULL, '1', NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '21', '32'),
        
        (NULL, '14', '1', NULL, NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, '1', '20', '30'),
        
        (NULL, '15', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '1', NULL, NULL, '1', NULL, '18', '30'),
        
        (NULL, '16', '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '1', NULL, NULL, '1', '18', '23'),
        
        (NULL, '17', '1', '1', NULL, '1', NULL, '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '18', '26'),
        
        (NULL, '18', '1', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', NULL, '1', '1', NULL, NULL, NULL, '18', '39'),
        
        (NULL, '19', '1', '1', NULL, '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '21', '39'),
        
        (NULL, '20', '1', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', '36', '69'),
        
        (NULL, '21', '1', NULL, NULL, NULL, '1','1', '1', NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '50', '78'),
        
        (NULL, '22', '1', NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '30', '45'),
        
        (NULL, '23', '1', NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL, '1', NULL, '1', '1', NULL, NULL, NULL, '18', '41'),
        
        (NULL, '24', '1', '1', NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, '25', '36'),
        
        (NULL, '25', '1', NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, '1', NULL, '18', '33'),
        
        (NULL, '26', '1', NULL, NULL, '1', NULL, NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', '18', '36'),
        
        (NULL, '27', '1', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '26', '46'),
        
        (NULL, '28', '1', NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL, '1', NULL, '21', '36'),
        
        (NULL, '29', '1', NULL, '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '20', '34'),
        
        (NULL, '30', '1', NULL, '1', '1', NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, '1', NULL, NULL, NULL, NULL, '24', '35'),
        
        (NULL, '31', '1', '1', NULL, NULL, '1', '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, '21', '30'),
        
        (NULL, '32', '1', NULL, NULL, '1', NULL, '1', '1', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '25', '32'),
        
        (NULL, '33', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, '1', NULL, '1', '1', NULL, NULL, NULL, '18', '38'),
        
        (NULL, '34', '1', '1', NULL, NULL, '1', '1', NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27', '45'),
        
        (NULL, '35', '1', NULL, '1', NULL, '1', NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, '1', '18', '23'),
        
        (NULL, '36', '1', NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', NULL, '1', '30', '48'),
        
        (NULL, '38', '1', '1', '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', '19', '25'),
        
        (NULL, '39', '1', NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '25', '37'),
        
        (NULL, '40', '1', '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, '30', '40'),
        
        (NULL, '41', '1', NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, '1', '1', NULL, NULL, '29', '44'),
        
        (NULL, '42', '1', NULL, '1', NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, '20', '40');";

        $created = $pdo->query($sql, PDO::ERRMODE_EXCEPTION);
        if (!$created)
        {
            echo '<h3 style="color: red;">Error Adding Interests Into Table</h3>';
        }else{
            echo '<h3 style="color: green;">Interests Into Table was a success</h3>';
        }
    }

}catch(PDOException $e){
    throw new PDOException($e->getMessage(), $e->getCode());
}

try{
    if ($pdo)
    {
        $sql = "INSERT INTO ".database('mysql/database').".`mates` (`id`, `reqID`, `provID`, `accepted`) 
        VALUES
        (NULL, '2', '60', '1'),
        (NULL, '13', '2', '1'),
        (NULL, '2', '26', '1'),
        (NULL, '15', '16', '1'),
        (NULL, '53', '21', '1'),
        (NULL, '23', '31', '1'),
        (NULL, '29', '35', '1'),
        (NULL, '14', '25', '1'),
        (NULL, '19', '15', '1'),
        (NULL, '17', '25', '1'),
        (NULL, '14', '22', '1'),
        (NULL, '37', '60', '1'),
        (NULL, '27', '22', '1'),
        (NULL, '56', '25', '1'),
        (NULL, '58', '15', '1'),
        (NULL, '29', '15', '1'),
        (NULL, '34', '46', '1'),
        (NULL, '2', '35', '1'),
        (NULL, '33', '36', '1'),
        (NULL, '32', '45', '1'),
        (NULL, '33', '41', '1'),
        (NULL, '15', '43', '1'),
        (NULL, '15', '40', '1'),
        (NULL, '21', '25', '1'),
        (NULL, '56', '34', '1'),
        (NULL, '53', '33', '1'),
        (NULL, '6', '33', '1'),
        (NULL, '46', '32', '1'),
        (NULL, '11', '31', '1'),
        (NULL, '2', '49', '1'),
        (NULL, '27', '35', '1'),
        (NULL, '56', '23', '1'),
        (NULL, '29', '24', '1'),
        (NULL, '2', '52', '1'),
        (NULL, '9', '45', '1'),
        (NULL, '11', '53', '1'),
        (NULL, '12', '34', '1'),
        (NULL, '62', '34', '1'),
        (NULL, '23', '25', '1'),
        (NULL, '3', '35', '1'),
        (NULL, '9', '4', '1'),
        (NULL, '13', '2', '1'),
        (NULL, '31', '4', '1'),
        (NULL, '23', '5', '1'),
        (NULL, '30', '6', '1'),
        (NULL, '31', '35', '1'),
        (NULL, '33', '16', '1'),
        (NULL, '23', '6', '1'),
        (NULL, '37', '60', '1'),
        (NULL, '29', '60', '1');";
        $created = $pdo->query($sql);
        if (!$created){
            echo '<h3 style="color: red;">Error Mating Users Into Table</h3>';
        }else{
            echo '<h3 style="color: green;">Mating Users Into Table was a success</h3>';
        }
    }

}catch(PDOException $e){
    throw new PDOException($e->getMessage(), $e->getCode());
}


sleep(3);
header('Location: ../index.php');
?>