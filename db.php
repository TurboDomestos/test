<?php
/**
 * Created by PhpStorm.
 * User: Syntax
 * Date: 03.05.2018
 * Time: xx;xx
 */

class db {
    protected $host = 'localhost';
    protected $Suser = 'root';
    protected $pass = '';
    protected $dbname = 'test';

    public $mysqli_connect;

    public function dbConnect() {
        if($this->mysqli_connect) {
            return $this->mysqli_connect;
        }

        $mysqli = new mysqli($this->host,$this->Suser,$this->pass,$this->dbname);

        if ($mysqli->connect_errno) {
            return false;
        }
        $mysqli->query("SET names UTF8;");

        return $this->mysqli_connect = $mysqli;
    }

    public function createUser($first_name , $last_name , $age , $birth_date ){
        if (!$mysqli = $this->dbConnect()) {
            return false;
        }

        $status = $mysqli->query("INSERT INTO users (first_name, last_name, age, birth_date)
        VALUES ('$first_name', '$last_name', '$age', '$birth_date') ") or die($mysqli->error);

        if (!$status) {
            return false;
        }else{
            return 1;
        }
    }
}

?>