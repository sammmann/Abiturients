<?php

/**
 * Class Abiturient
 *
 * @package app
 * @author sammmann
 *
 * Класс отражающий сущность абитуриента из базы данных.
 * Содержит поля, имена которых соответствуют полям в таблице.
 * Содержит два переопределенных метода.
 */
class Abiturient{
    
    public $abt_id = "0";
    public $abt_name = "#";
    public $abt_second = "#";
    public $abt_gender = "1";
    public $abt_group = "#";
    public $abt_email = "#";
    public $abt_points = "0";
    public $abt_birth_year = "0000";
    public $abt_is_local = "0";
    public $abt_pass = "#";
    public $abt_photo = "";
    
    public function __construct($name, $second, $gender, $group, $email, $points, $year, $is_local, $photo)
    {
        $this->abt_name = $name;
        $this->abt_second = $second;
        $this->abt_gender = $gender;
        $this->abt_group = $group;
        $this->abt_email = $email;
        $this->abt_points = $points;
        $this->abt_birth_year = $year;
        $this->abt_is_local = $is_local;
        $this->abt_photo = $photo;
    }
    
    public function __toString(){
        return $this->abt_name . " " . $this->abt_second . " " . $this->abt_gender . " " .
            $this->abt_group . " " . $this->abt_email . " " . $this->abt_points . " " .
            $this->abt_birth_year . " " . $this->abt_is_local;
    }

}