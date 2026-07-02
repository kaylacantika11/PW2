<?php
require_once "../config/database.php";
class User {
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function register($username,$password)
    {
        $password = password_hash(
            $password,PASSWORD_DEFAULT
        );
        return mysqli_query(
            $this->conn, "INSERT INTO users(username,password) VALUES('$username','$password')"
        );
    }
    public function login($username,$password)
    {
        $query = mysqli_query(
            $this->conn, "SELECT * FROM users WHERE username='$username'"
        );
        $user = mysqli_fetch_assoc($query);
        if($user)
        {
            if(password_verify($password,$user['password']))
            {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }

        return false;
    }
}
?>