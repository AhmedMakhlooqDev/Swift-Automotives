<?php
//include the database class for the connection to the database
include_once "./database.php";

class User
{

    //variables
    private $USER_ID;
    private $USER_FIRST_NAME;
    private $USER_LAST_NAME;
    private $USER_NUMBER;
    private $USER_EMAIL;
    private $USER_PASSWORD;
    private $USER_TYPE_ID;
    private $GENDER;
    private $NATIONALITY;
    /*
    *@var mysqli
    */
    private $connection;


    public function __construct()
    {
        //set the default value of the variables
        $this->USER_ID = null;
        $this->USER_FIRST_NAME = null;
        $this->USER_LAST_NAME = null;
        $this->USER_NUMBER = null;
        $this->USER_EMAIL = null;
        $this->USER_PASSWORD = null;
        $this->USER_TYPE_ID = null;
        $this->GENDER = null;
        $this->NATIONALITY = null;
        //get and store the connection of mysqli
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getUSER_ID()
    {
        return $this->USER_ID;
    }

    public function setUSER_ID($USER_ID)
    {
        $this->USER_ID = $USER_ID;
    }

    public function getUSER_FIRST_NAME()
    {
        return $this->USER_FIRST_NAME;
    }

    public function setUSER_FIRST_NAME($USER_FIRST_NAME)
    {
        $this->USER_FIRST_NAME = $USER_FIRST_NAME;
    }

    public function getUSER_LAST_NAME()
    {
        return $this->USER_LAST_NAME;
    }

    public function setUSER_LAST_NAME($USER_LAST_NAME)
    {
        $this->USER_LAST_NAME = $USER_LAST_NAME;
    }

    public function getUSER_NUMBER()
    {
        return $this->USER_NUMBER;
    }

    public function setUSER_NUMBER($USER_NUMBER)
    {
        $this->USER_NUMBER = $USER_NUMBER;
    }

    public function getUSER_EMAIL()
    {
        return $this->USER_EMAIL;
    }

    public function setUSER_EMAIL($USER_EMAIL)
    {
        $this->USER_EMAIL = $USER_EMAIL;
    }

    public function getUSER_PASSWORD()
    {
        return $this->USER_PASSWORD;
    }

    public function setUSER_PASSWORD($USER_PASSWORD)
    {
        $this->USER_PASSWORD = $USER_PASSWORD;
    }

    public function getUSER_TYPE_ID()
    {
        return $this->USER_TYPE_ID;
    }

    public function setUSER_TYPE_ID($USER_TYPE_ID)
    {
        $this->USER_TYPE_ID = $USER_TYPE_ID;
    }

    public function getGENDER()
    {
        return $this->GENDER;
    }

    public function setGENDER($GENDER)
    {
        $this->GENDER = $GENDER;
    }

    public function getNATIONALITY()
    {
        return $this->NATIONALITY;
    }

    public function setNATIONALITY($NATIONALITY)
    {
        $this->NATIONALITY = $NATIONALITY;
    }


    //set the values of the instance
    public function initWith($user_id, $f_name, $l_name, $user_number, $email, $u_password, $user_type_id, $gender, $nationality)
    {
        $this->USER_ID = $user_id;
        $this->USER_FIRST_NAME = $f_name;
        $this->USER_LAST_NAME = $l_name;
        $this->USER_NUMBER = $user_number;
        $this->USER_EMAIL = $email;
        $this->USER_PASSWORD = $u_password;
        $this->USER_TYPE_ID = $user_type_id;
        $this->GENDER = $gender;
        $this->NATIONALITY = $nationality;
    }

    //call this after initWith
    //add the user to the database
    public function add()
    {
        if (!$this->checkEmail()) {
            //sql quary to be executed in the database
            $sql = "INSERT INTO dbproj_user(USER_FIRST_NAME,USER_LAST_NAME,USER_NUMBER,USER_EMAIL,USER_PASSWORD,USER_TYPE_ID,GENDER,NATIONALITY) VALUES (?,?,?,?,?,1,?,?)";
            //prepare the sql
            $stmt = $this->connection->prepare($sql);
            //hash the password 
            $hashedPassword = password_hash($this->USER_PASSWORD, PASSWORD_DEFAULT);
            $this->USER_PASSWORD = $hashedPassword;
            //add the param values
            $stmt->bind_param("sssssss", $this->USER_FIRST_NAME, $this->USER_LAST_NAME, $this->USER_NUMBER, $this->USER_EMAIL, $hashedPassword, $this->GENDER, $this->NATIONALITY);
            //execute the quary
            $stmt->execute();
            //get the inserted id and set it to the instance
            $this->USER_ID = $stmt->insert_id;
            //
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $pass)
    {
        $sql = "SELECT * FROM dbproj_user where USER_EMAIL = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        echo $stmt->error;
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_object();
            $this->USER_ID = @$row->USER_ID;
            $this->USER_PASSWORD = @$row->USER_PASSWORD;
            //check if u_password is valid 
            if (password_verify($pass, $this->USER_PASSWORD)) {
                echo "this is working";
                //set the session for the logged in user
                $_SESSION["user_id"] = $row->USER_ID;
                return true;
            } 
        }
        return false;
    }

    //check if the email is used
    public function checkEmail()
    {
        //sql quary to be executed in the database
        $sql = "SELECT * FROM dbproj_user WHERE USER_EMAIL = ?";
        //prepare the sql quaery for param
        $stmt = $this->connection->prepare($sql);
        //set the values of the param
        $stmt->bind_param("s", $this->USER_EMAIL);
        //execute the queary
        $stmt->execute();
        //get singal row from the database
        $result = $stmt->get_result()->fetch_object();
        //return true if there is no user with this email
        if (empty($result)) {

            return false;
        } else {

            return true;
        }
    }

    public function isAdmin()
    {
        $uid = $_SESSION["user_id"];
        $sql = "SELECT * FROM dbproj_user WHERE `USER_ID` = $uid";
        if ($result = $this->connection->query($sql)) {
            $userData = $result->fetch_object();
            if ($userData->USER_TYPE_ID == '2') {
                return true;
            }else{
                return false;
            }
        } 
        
    }
}
