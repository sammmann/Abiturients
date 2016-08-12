<?php

/**
 * Class PDOConnector
 * 
 * @package app
 * @author sammmann
 * 
 * Класс, отвечающий за создание подключения PDO к базе данных.
 * Берез основные параметры подключения в файле settings.json
 * 
 */
class PDOConnector{

    private $DBH = null;

    public function __construct() {

    }

    public function connect() {
        // подключение к базе данных

        try{
                //decode JSON string to get database settings
                $json_string = file_get_contents("../app/settings.json");
                $dbSettings = json_decode($json_string, true);

                $host = $dbSettings['db']['host'];
                $dbname = $dbSettings['db']['dbname'];
                $user = $dbSettings['db']['user'];
                $password = $dbSettings['db']['password'];

                //uncomment to see json string
                //echo '<pre>' . print_r($dbSettings, true) . '</pre>';

                $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->DBH;

            }
            catch(PDOException $e) {
                file_put_contents('../app/PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                return NULL;
            }
    }

    public function disconnect(){
        //закрываем подключение
        $this->DBH = null;
    }
    
    public function getConnection(){
        return $this->DBH;
    }
}