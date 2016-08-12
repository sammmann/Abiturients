<?php

/**
 * Class AbiturientDataGateway
 *
 * @package app
 * @author sammmann
 *
 * Клас реализующий патерн TableDataGateway для класса Abiturient.
 * Отвечает за подготовку и выполнение различных запросов к базе данных.
 * Использует PDO для работы с базой данных.
 * Загружает фотографию пользователя на сервер (стоит исключить?).
 */

class AbiturientDataGateway{

    private $con = null;
    
    public $countUserQueryRows = 0;
    
    public $failed = false;

    public function __construct(PDO $con) {
        $this->con = $con;
    }

    public function getAbiturientList(Pagenator $pagenator, $orderBy , $sorted){
        try{
            $abtList = array();

            $prepare_query = "SELECT abt_name, abt_second, abt_group, abt_points, abt_photo 
                              FROM abiturient_list 
                              ORDER BY " . $orderBy . " " . $sorted .
                              " LIMIT " . $pagenator->start() . ', ' . $pagenator->rows_per_page;

            $STH = $this->con->query($prepare_query);

            $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Abiturient');

            while($row = $STH->fetch()) {
                $abtList[] = $row;
            }

            return $abtList;

        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
        catch (Exception $e) {
            $this->failed = true;
            file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
    }

    public function setNewAbiturient(Abiturient $abiturient){
        
        try {

            $query = "INSERT INTO abiturient_list (abt_name, abt_second, abt_gender, abt_group, abt_email,
                  abt_points, abt_birth_year, abt_is_local, abt_pass, abt_photo) 
                  VALUES ('$abiturient->abt_name', '$abiturient->abt_second', '$abiturient->abt_gender', '$abiturient->abt_group',
                   '$abiturient->abt_email', '$abiturient->abt_points', '$abiturient->abt_birth_year', 
                   '$abiturient->abt_is_local', '$abiturient->abt_pass', '$abiturient->abt_photo')";

            $STH = $this->con->prepare($query);

            $STH->execute((array)$abiturient);
        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
        
        $this->loadPhoto();
    }
    
    public function isUniqueEmail($email, $update = false){

        try {

            if ($update){

                $curr_id = $_COOKIE['abt_id'];

                $STH = $this->con->query("SELECT COUNT(*) 
                                          FROM abiturient_list 
                                          WHERE abt_email='$email'
                                          AND abt_id <>'$curr_id'");

                return $STH->fetchColumn() == 0 ? true : false;
            }
            else{
                $STH = $this->con->query("SELECT COUNT(*) FROM abiturient_list WHERE abt_email='$email'");
                return $STH->fetchColumn() == 0 ? true : false;
            }

        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
    }

    private function debugQueryOnScreen($a){
        $query = "INSERT INTO abiturient_list (abt_name, abt_second, abt_gender, abt_group, abt_email, 
                  abt_points, abt_birth_year, abt_is_local) 
                  VALUES ('$a->abt_name', '$a->abt_second', '$a->abt_gender', '$a->abt_group', '$a->abt_email', 
                  '$a->abt_points', '$a->abt_birth_year', '$a->abt_is_local')";

        echo $query;
    }
    
    public function totalAbiturients(){
        $STH = $this->con->query("SELECT COUNT(*) FROM abiturient_list");
        return $STH->fetchColumn();
    }

    public function totalAbiturientsInQuery($query){
        $STH = $this->con->query($query);
        return $this->countUserQueryRows = $STH->fetchColumn();
    }

    public function searchAbiturients(Pagenator $pagenator, $orderBy , $sorted, $query){
        $abtSearchedList = array();

        if (count($query) == 2){

            $queryStringOne = $query['1'];
            $stringTwo = $query['2'];

            try {

                $count_query = "SELECT COUNT(*) 
                                FROM abiturient_list 
                                WHERE abt_name
                                LIKE '%" . $queryStringOne . "%' " .
                               "AND abt_second 
                                LIKE '%" . $stringTwo . "%'";


                $prepare_query = "SELECT abt_name, abt_second, abt_group, abt_points, abt_photo
                                  FROM abiturient_list 
                                  WHERE abt_name
                                  LIKE '%" . $queryStringOne . "%' " .
                                 "AND abt_second 
                                  LIKE '%" . $stringTwo . "%' " .
                                 "ORDER BY " . $orderBy . " " . $sorted .
                                 " LIMIT " . $pagenator->start() . ', ' . $pagenator->rows_per_page;

                $STH = $this->con->query($prepare_query);

                $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Abiturient');

                $pagenator->total_pages = ceil($this->totalAbiturientsInQuery($count_query) /
                    $pagenator->rows_per_page);

                while ($row = $STH->fetch()) {
                    $abtSearchedList[] = $row;
                }

                return $abtSearchedList;
            }
            catch (PDOException $e){
                $this->failed = true;
                file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
                return null;
            }
            catch (Exception $e) {
                $this->failed = true;
                file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
                return null;
            }

        }
        elseif (count($query) == 1) {

            $queryStringOne = $query['1'];

            try {

                $count_query = "SELECT COUNT(*) 
                                FROM abiturient_list 
                                WHERE abt_name 
                                LIKE '%" . $queryStringOne . "%' " .
                               "OR abt_second 
                                LIKE '%" . $queryStringOne . "%'";

                $prepare_query = "SELECT abt_name, abt_second, abt_group, abt_points, abt_photo 
                                  FROM abiturient_list 
                                  WHERE abt_name
                                  LIKE '%" . $queryStringOne . "%' " .
                                 "OR abt_second 
                                  LIKE '%" . $queryStringOne . "%' " .
                                 "ORDER BY " . $orderBy . " " . $sorted .
                                 " LIMIT " . $pagenator->start() . ', ' . $pagenator->rows_per_page;

                $STH = $this->con->query($prepare_query);

                $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Abiturient');

                $pagenator->total_pages = ceil($this->totalAbiturientsInQuery($count_query) /
                    $pagenator->rows_per_page);

                while ($row = $STH->fetch()) {
                    $abtSearchedList[] = $row;
                }

                return $abtSearchedList;
            } catch (PDOException $e) {
                $this->failed = true;
                file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
                return null;

            }
            catch (Exception $e) {
                $this->failed = true;
                file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
                return null;
            }
        }
        else{
            file_put_contents('../app/LogErrors.txt', 
                "Неправильное числов поисковых параметров" . 
                PHP_EOL, FILE_APPEND);
            return null;
        }

    }
    
    public function getIdByPass($pass){

        try{
            $STH = $this->con->query("SELECT abt_id FROM abiturient_list WHERE abt_pass='$pass'");

            $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Abiturient');

            $abt = $STH->fetch();

            return $abt->abt_id;
        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
        catch (Exception $e) {
            $this->failed = true;
            file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }

    }
    
    public function getAbiturientById($id){
        try{
            $STH = $this->con->query("SELECT * FROM abiturient_list WHERE abt_id='$id' LIMIT 1");

            $STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Abiturient');

            $abt = $STH->fetch();

            return $abt;
        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
        catch (Exception $e) {
            $this->failed = true;
            file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
    }
    
    public function updateAbiturientAccount($id, $abiturient){
        $curr_id = $_COOKIE['abt_id'];
        
        try {

            $query = "UPDATE  abiturient_list 
                  SET abt_name='$abiturient->abt_name', abt_second='$abiturient->abt_second', 
                  abt_gender='$abiturient->abt_gender', abt_group='$abiturient->abt_group', 
                  abt_email='$abiturient->abt_email', abt_points='$abiturient->abt_points',
                  abt_birth_year='$abiturient->abt_birth_year', abt_is_local='$abiturient->abt_is_local',
                  abt_photo = '$abiturient->abt_photo'
                  WHERE abt_id='$curr_id'";

            $STH = $this->con->prepare($query);

            $STH->execute();
        }
        catch (PDOException $e){
            $this->failed = true;
            file_put_contents('../app/PDOErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }
        catch (Exception $e) {
            $this->failed = true;
            file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return null;
        }

        $this->loadPhoto();
        
    }

    private function loadPhoto()
    {
        try {
            $image = $_FILES['abt_photo']['name'];
            $image_tmp = $_FILES['abt_photo']['tmp_name'];
            move_uploaded_file($image_tmp, "img/photos/$image");
        }
        catch (Exception $e) {
            $this->failed = true;
            file_put_contents('../app/LogErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }
}