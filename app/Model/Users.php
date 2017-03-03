<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 9/7/2016
 * Time: 8:05 AM
 */

class Users extends Security {
    public $debug = TRUE;
    protected $db_pdo;


    public function createAccount(){

        $userType = 'client';
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $pass = $this->makeHash('encrypt', $password);
        $firstName = addslashes($_POST['firstName']);
        $middleName = addslashes($_POST['middleName']);
        $lastName = addslashes($_POST['lastName']);
        $address = addslashes($_POST['address']);
        $city = addslashes($_POST['city']);
        $state = addslashes($_POST['state']);
        $zip = addslashes($_POST['zip']);
        $contact = addslashes($_POST['contact']);
        $dob = date('Y-m-d', strtotime($_POST['dob']));

        try{
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `users` (`userType`, `email`, `password`, `firstName`,`middleName`, `lastName`, `address`, `city`, `state`, `zip`, `contactNumber`, `dob`)
                    VALUES ("' . $userType . '",
                            "' . $email . '",
                            "' . $pass . '",
                            "' . $firstName . '",
                            "' . $middleName . '",
                            "' . $lastName . '",
                            "' . $address . '",
                            "' . $city . '",
                            "' . $state . '",
                            "' . $zip . '",
                            "' . $contact . '",
                            "' . $dob . '")';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();

            $location = '../login';

        }catch (Exception $e){
            $location = $_SERVER['PHP_SELF'] .'?success=false&msg=Something went wrong, please try again';
        }

        header('Location: ' . $location . '');

    }

    public function loginByName($user, $password)
    {

        $password = $this->makeHash('encrypt', $password);
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `users` WHERE `email` = "' . $user . '" AND `password` = "' . $password . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($user, $password));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function logout()
    {
        unset($_SESSION['user_name']);
        unset($_SESSION['login']);
        session_unset();
        session_destroy();
        header('Location: login');

    }

    /*
   * Database functions
   */


    public function pdoQuoteValue($value)
    {
        $pdo = $this->getPdo();
        return $pdo->quote($value);
    }



    public function getPdo()
    {
        if (!$this->db_pdo)
        {
            if ($this->debug)
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }
            else
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD);
            }
        }
        return $this->db_pdo;
    }
}