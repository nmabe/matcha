<?php

class       Mail{

    private $_user,
            $_email,
            $_headers = '';

    public function __construct($id)
    {
        $from = "nmabe@student.wethinkcode.co.za";
        $this->_headers = "From:" . $from. "\r\n";
        $this->_headers .= "MIME-Version: 1.0\r\n";
        $this->_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $this->_user = new User($id);
        $this->_email = $this->_user->data()->email;
    }

    public function sendRequest($provid, $reqId)
    {
        $username = $this->_user->data()->fullname;
        $mate = new User($provid);
        if ($this->_user) {
            $body = $str;
            $to = $mate->data()->email;
            $subject = "You Have A Mate Request";
            $str = "Hello {$mate->data()->fullname} <br><br>You are Receiving this email because {$user->data()->fullname} Has Asked to be Your Mate on Matcha.<br>To View and start chatting with {$user->data()->fullname} on Matcha.<br><br>Please Use the Links below to view and accept this Mate Request.";
            $page = <<<HTML
                <head>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   </head>
                <body>
                    <div class="header">
                    <a style="text-decoration: none; color:#1a0000;font-family: 'Kumar One Outline', cursive;" href="http://127.0.0.1:8080/matcha/index.php"><h1 align="center">Matcha 💖</h1></a>
                    </div>

                <div class="container">
                    <div class="jumbotron">
                        <h1 align="center">You have a mate request</h1> <br><hr>
                        <p>$str</p> 
                        <p align="center"><a class="btn btn-danger" href="http://127.0.0.1:8080/matcha/user.php?provID={$provid}&reqID={$reqId}">Accept Request</a></p>
                    </div>
                    <div class="footer card-footer">
                       <p>Yours truly,<br>
                       nmabe &reg matcha 2018 &copy;<br>
                       <a href="../index.php">www.matcha.com<br></a>
                       <a href="nmabe@student.wethinkcode.co.za">contact: infor@matcha.com<br></a>
                       Find Your Match</p>
                    </div>
                </body>
HTML;


            $mailed = mail($to, $subject, $page, $this->_headers);
            if ($mailed)
                return (true);
            else
                return (false);
        }
        return (false);
    }

    public function changePassword($code)
    {
        if ($this->_user)
        {
            $str = "Hello {$this->_user->data()->fullname} <br><br><small></small>You are Receiving this email because you have requested to change Your Matcha account password.<br>To change on Matcha.<br>if you did not make this request<br><br>Please Use the Links below and use the code to reset you password <br><br><h4 style=\"color: red\">code: {$code}</h4>.";
            $page = <<<HTML
                <head>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
           </head>
                <body>
                    <div class="header">
                    <a style="text-decoration: none; color:#1a0000;font-family: 'Kumar One Outline', cursive;" href="http://127.0.0.1:8080/matcha/index.php"><h1 align="center">Matcha <i class="fal fa-heart">💖</i></h1></a>
                    </div>

                <div class="container">
                    <div class="jumbotron">
                        <h1 align="center">Change Your Password</h1> <br><hr>
                        <p>$str</p>
                        <p align="center"><a class="btn btn-danger" href="http://127.0.0.1:8080/matcha/changePassword.php?username={$this->_user->data()->username}">Change Password</a></p>
                    </div>
                    <div class="footer card-footer">
                    <p>Yours truly,<br>
                    nmabe &reg matcha 2018 &copy;<br>
                    <a href="../index.php">www.matcha.com<br></a>
                    <a href="nmabe@student.wethinkcode.co.za">contact: infor@matcha.com<br></a>
                    Find Your Match</p>
                    </div>
                </body>
HTML;
            $subject = "Change Your Password";
            $mailed = mail($this->_email, $subject, $page, $this->_headers);

            if ($mailed)
            {
                return (true);
            }
            else
            {
                return (false);
            }
        }
        return(true);
    }
}

?>