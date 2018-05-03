<?php
/**
 * Created by PhpStorm.
 * User: Syntax
 * Date: 03.05.2018
 * Time: xx;xx
 */
header('Content-type: text/html; charset=utf-8');


require 'db.php';

class user extends db
{

    //если нужна будет добавить параметр то просто добавь в массив $attributes и напишите мэтод валидации для нового параметра newparamValidate();

    public $attributes = [
        'first_name',
        'last_name',
        'age',
        'birth_date',
    ];

    //get user datas (not valid)
    public $userData = [];

    //user valid data
    public $user = [];

    public function getParams()
    {
        if (!$_GET || empty($_GET)) {

            echo "Where is params???" . "<br>";

            return false;
        }
        $this->userData = $_GET;
    }

    public function ageValidate($age)
    {
        if (empty($age) || ($age == 0) || !is_numeric($age) || (strlen($age) > 2)) {

            echo "bad age params so  your new age = 0" . "<br>";

            $this->user['age'] = 0;
        } else {
            $this->user['age'] = $age;
        }
    }

    public function first_nameValidate($first_name)
    {
        if (!preg_match("/^[a-zA-Zа-яА-Я'][a-zA-Zа-яА-Я-' ]+[a-zA-Zа-яА-Я']?$/u", $first_name) || (strlen($first_name) > 25)) {

            echo "bad firstname params so  your first name = Noob " . "<br>";

            $this->user['first_name'] = "Noob";
        } else {
            $this->user['first_name'] = $first_name;
        }
    }

    public function last_nameValidate($last_name)
    {
        //дублируется код если будет не лень придумай фичу
        if (!preg_match("/^[a-zA-Zа-яА-Я'][a-zA-Zа-яА-Я-' ]+[a-zA-Zа-яА-Я']?$/u", $last_name) || (strlen($last_name) > 25) ) {

            echo "bad firstname params so  your last name = Noob " . "<br>";

            $this->user['last_name'] = "Noob";
        } else {
            $this->user['last_name'] = $last_name;
        }
    }

    public function birth_dateValidate($birth_date)
    {
        if (preg_match("/^(\d{1,2})[\s\.\/\-]?(\d{1,2})[\s\.\/\-]?(\d{2}(\d{2})?)$/", $birth_date, $arr) && checkdate($arr[2], $arr[1], $arr[3])) {
            if (!isset($arr[3][3])) {
                if ((date('y') + "2") > $arr[3]) {
                    $arr[3][2] = '2';
                    $arr[3][3] = '0';
                } else {
                    $arr[3][2] = '1';
                    $arr[3][3] = '9';
                }
            }
            $target_date = $arr[1] .".". $arr[2] .".". $arr[3];

            $this->user['birth_date'] = $target_date;
        }else{
            echo "bad date new date is -> 10.10.10 "."<br>";
            $this->user['birth_date'] = "10.10.10";
        }
    }

    public function validate()
    {
        foreach ($this->attributes as $key) {
            if (!isset($this->userData[$key]) || empty($this->userData[$key])) {
                $this->userData[$key] = 1;
            }
            $this->{$key . 'Validate'}(htmlentities($this->userData[$key]));
        }
    }

    public function create(){
        echo "<pre>";
        $this->getParams();
        $this->validate();
        print_r($this->user);
        if($this->createUser($this->user['first_name'],$this->user['last_name'],$this->user['age'],$this->user['birth_date'])){
            echo "nice work check DB->table"."<br>";
        }
    }
}

