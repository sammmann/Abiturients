<?php
/**
 * Файл настроек
 *
 * Данный файл содержит основные настройки,
 * необходимые для работы каждой страницы приложения:
 * переопределяет функцию автозагрузки классов
 * создает PDO подключение
 * создает экземпляр шлюза к базе данных
 * определяет функцию закрытия подключения к базе данных
 */

//autoload function
function __autoload($class_name){
    $file = "../app/" . $class_name . ".php";
    require_once $file;
}

//PDO connect here
$con = new PDOConnector();
$con->connect();

//Make gateway to the DB
$ADG = new AbiturientDataGateway($con->getConnection());

function closeDB($con, $ADG){
    //Close DB connection and gateway object
    try {
        $con->disconnect();
        unset($ADG);
        return true;
    }
    catch (Exception $e){
        return false;
    }
}