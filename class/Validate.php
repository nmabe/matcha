<?php
/**
 * Created by PhpStorm.
 * User: nmabe
 * Date: 10/5/2018
 * Time: 12:52 AM
 */

class Validate
{
    private $_passed = false,
        $_errors = array(),
        $_db = null,
        $_page;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rules_val) {
                if (isset($source[$item]))
                    $value = trim($source[$item]);
                $item = escape($item);
                if ($rule === "required" && empty($value)) {
                    $this->addError("{$item} is Required");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rules_val)
                                $this->addError("{$item} Must Be a Minimum of {$rules_val} Characters");
                            break;
                        case 'max':
                            if (strlen($value) > $rules_val)
                                $this->addError("{$item} Must Be a Maximum of {$rules_val} Characters");
                            break;
                        case 'match':
                            if ($value != $source[$rules_val]) {
                                $this->addError("{$rules_val} Must Match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rules_val, array($item, '=', $value));
                            if ($check->count())
                                $this->addError("{$item} Already Exists");
                            break;
                        case 'gender':
                            $ruler = $rules['gender'];
                            if ($ruler[0] !== $value && $ruler[1] !== $value)
                                $this->addError("{$item} Should be Male or Female");
                            break;
                        case 'strong':
                            if((!preg_match("#[0-9]+#", $value)) || (!preg_match("#[a-zA-Z]+#", $value)))
                                $this->addError("{$item} should Include atleast one Uppercase and one number");
                            break;
                        case 'restriction':
                            $age = (intval(date('Y')) - intval(explode('-', $_POST['dob'])[0]));
                            if($age < $rules_val)
                                $this->addError("No under {$rules_val}'s allowed");
                            break;
                        case 'exists':
                            $check = $this->_db->get($rules_val, array($item, '=', $value));
                            if (!$check->count())
                                $this->addError("{$item} Not Found");
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return ($this);
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }


    public function Verifymail($code, $username, $email)
    {
        $user = new User($username);
        if ($this->passed()) {
            $to = escape($email);
            $subject = "Activate your Matcha account";
            $from = "nmabe@student.wethinkcode.co.za";
            $str = "Hello {$user->data()->fullname} <br><br><small></small>You've received this email because your email address was used for
            registering/updating your Matcha account.<br>Please follow this link to confirm your decision and start using Matcha online
            for free to start finding your match.<br><br><h4 style=\"color: red\">code: {$code}</h4>.";
            $page = <<<HTML
                <head>
            <link rel="stylesheet" href="css/bootstrap.min.css">
                <script src="js/jquery.min.js"></script>
                <script src="js/popper.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/main.js"></script>    </head>
                <body>
                    <div class="header">
                    <a style="text-decoration: none; color:#1a0000;font-family: 'Kumar One Outline', cursive;" href="http://127.0.0.1:8080/matcha/index.php"><h1 align="center">Matcha 💖</h1></a>
                    </div>

                <div class="container">
                    <div class="jumbotron">
                        <h1 align="center">Verify Your Account</h1> <br><hr>
                        <p>$str</p>
                        <p align="center"><a class="btn btn-danger" href="http://127.0.0.1:8080/matcha/verify.php?username={$username}&code={$code}.">Confirm Account</a></p>
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
            $headers = "From:" . $from. "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $mailed = mail($to, $subject, $page, $headers);
            if ($mailed)
                return (true);
            else
                return (false);
        }
        return (false);
    }

    public function error()
    {
        return ($this->_errors);
    }

    public function passed()
    {
        return ($this->_passed);
    }

}