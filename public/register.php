<?php
/**
 * Создает представление страницы пользователя сайта
 * 
 * В зависимости от переданных методом get параметров
 * и параметров, установленных в cookie пользователя,
 * данный файл либо выводи форму регистрации нового пользователя,
 * либо форму редактирования информации уже зарегестрированного абитуриента.
 * Также проверяет отправлена ли форма методом post.
 * Если отправлена, то экземпляру класса Abiturient
 * присваиваются значения из формы. Далее данный объект
 * проходит процедуру валидации с помощью класса Validator.
 * Если процедура проходит успешно, то новая информация либо заносится в базу,
 * либо обновляется уже существующая.
 */
require_once ("../app/init.php");

//values
$abiturient = new Abiturient("", "", "", "", "", "", "", "", "");
//errors
$form_errors = array();

$abiturient_gender = 'male';
$abiturient_is_local = false;
$abiturient_photo = null;

$tmp = "abiturient_form.html";

if (isset($_COOKIE['abt_pass'])){
    $title = "Edit form";
    $btn_title = "Обновить";
}
else{
    $title = "Register form";
    $btn_title = "Зарегестрироваться";
}

if (isset($_GET['id'])){
    $abiturient = $ADG->getAbiturientById($_GET['id']);
    $abiturient_gender = $abiturient->abt_gender;
    $abiturient_is_local = $abiturient->abt_is_local;
    $abiturient_photo = $abiturient->abt_photo;
    setcookie('abt_id', $_GET['id'], time()+31536000);
}


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    //checking if form was sanded

    //Parse data from form to the object
    $abiturient->abt_name = strval(trim($_POST['abt_name']));
    $abiturient->abt_second = strval(trim($_POST['abt_second']));
    $abiturient->abt_gender = $_POST['abt_gender']; // 1 - male, 2 - female
    $abiturient->abt_group = strval(trim($_POST['abt_group']));
    $abiturient->abt_email = strval(trim($_POST['abt_email']));
    $abiturient->abt_points = $_POST['abt_points'];
    $abiturient->abt_birth_year = strval(trim($_POST['abt_birth_year']));
    $abiturient->abt_photo = $_FILES['abt_photo']['name'];
    isset($_POST['abt_is_local']) ? $abiturient->abt_is_local = 1 :
        $abiturient->abt_is_local = 0;

    //Validate data from form
    $form_errors = Validator::validate($abiturient, $ADG);
    $form_errors = Validator::$errors;

    if($form_errors){
        //There are some errors in the form

        //UNCOMMENT to see error dump
        //Validator::dumpErrorsAndFields();

        $title = "Form errors";
        $tmp = "abiturient_form.html";
        $tmp_errors = "form_errors.html";
        include_once "../views/account.html";

    }
    else{

        if (isset($_COOKIE['abt_pass'])){
            //update abiturient's profile
            $ADG->updateAbiturientAccount($_COOKIE['abt_id'], $abiturient);

            //close DB connect
            closeDB($con, $ADG);

            $title = "Register form";

            if ($ADG->failed){
                $comp_title = "Что-то пошло не так!";
            }
            else{
                $comp_title = "Ваши данные успешно обновлены!";
            }

            $tmp = "reg_complete.html";

            //Redirect on the main page after 5 second
            header('Refresh: 5, index.php');
        }
        else{
            //add new abiturient account

            //get new password
            $pass = Tokenizer::makeNewToken();

            $abiturient->abt_pass = $pass;

            //If no mistakes in the form then put data to the DB
            $ADG->setNewAbiturient($abiturient);

            //close DB connect
            closeDB($con, $ADG);

            $title = "Register form";

            if ($ADG->failed){
                $comp_title = "Что-то пошло не так!";
            }
            else{
                $comp_title = "Регистрация прошла успешно!";
                //Если все операции завершились успехом
                //устанавливаем пароль в куки на год
                setcookie('abt_pass', $pass, time()+31536000);
            }

            $tmp = "reg_complete.html";

            //Redirect on the main page after 5 second
            header('Refresh: 5, index.php');

        }

    }

}

include_once "../views/account.html";
