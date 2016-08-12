<?php

/**
 * Class Validator
 * 
 * @package app
 * @author sammmann
 * 
 * Класс отвечает за валидацию данных введенных пользователем в форму.
 * Записывает найденные ошибки в массив $errors, а также сохраняет неправильно
 * заполненные поля в массиве $error_fields.
 * Если в форме найдены ошибки, то пользователь получает соответствующее
 * сообщение, список того, что необходимо исправить и подсвеченные неправильные поля.
 * 
 */
class Validator{

    private static $maxStringLength = 30;

    public static $errors = null;
    
    public static $error_fields = array();
    
    public static function validate($abt, $ADG){


        Validator::validateLength($abt->abt_name, 'Name');

        Validator::validateLetters($abt->abt_name, 'Name');

        Validator::validateLength($abt->abt_second, 'Second');

        Validator::validateLetters($abt->abt_second, 'Second');

        Validator::validateGroupLength($abt->abt_group);

        Validator::validateLetterAndNumbers($abt->abt_group, 'Group');

        Validator::validateLength($abt->abt_email, 'Email');

        Validator::validateEmail($abt->abt_email);

        Validator::validateUniqueEmail($abt->abt_email, $ADG);

        Validator::validateNumbers($abt->abt_points, 'Points');

        Validator::validatePoints($abt->abt_points);

        Validator::validateBirthYear($abt->abt_birth_year);

        Validator::validatePhoto($abt->abt_photo);

        Validator::$error_fields = Validator::$error_fields ?
            array_unique(Validator::$error_fields) : Validator::$error_fields;

        return Validator::$errors;
    }

    private static function validateLength($str, $attr){
        if ($str == ''){
            Validator::$errors[$attr] = "Пожалуйста, заполните поле: " . $attr;
            Validator::$error_fields[] = $attr;
        }
        elseif ((strlen($str) > Validator::$maxStringLength)){
            Validator::$errors[$attr] = "Длина поля " . $attr . " превышена (максимум = 30 символов), 
                                         Вы ввели = " . strlen($str) . ".";
            Validator::$error_fields[] = $attr;
        }
    }

    private static function validateLetters($str, $attr){
        if (preg_match('/[^а-яА-Я\s-\']$/u', $str)){
            Validator::$errors[$attr] = "Поле " . $attr .
                                        " может содержать только русские буквы и апострой.";
            Validator::$error_fields[] = $attr;
        }
    }

    private static function validateGroupLength($group){
        if ($group == ''){
            Validator::$errors[] = "Пожалуйста, введите номер группы";
            Validator::$error_fields[] = "Group";
        }
        elseif ((mb_strlen($group) < 2)){
            Validator::$errors[] = "Короткий номер группы (минимальная длина = 2), 
                                    Вы ввели = " . mb_strlen($group) . ".";
            Validator::$error_fields[] = "Group";
        }
        elseif ((mb_strlen($group) > 5)){
            Validator::$errors[] = "Длинный номер группы (максимальная длина = 5), 
                                    Вы ввели = " . mb_strlen($group) . ".";
            Validator::$error_fields[] = "Group";
        }
    }

    private static function validateLetterAndNumbers($str, $attr){
        if (preg_match("/[а-яА-Я]/u", $str) && preg_match("/[0-9]/", $str)){
            //do nothing
        }
        else{
            Validator::$errors[] = "Поле " . $attr .
                                   " может содержать только русские буквы и цифры.";
            Validator::$error_fields[] = $attr;
        }
    }

    private static function validateNumbers($number, $attr){
        if (strlen($number) == 0){
            Validator::$errors[] = "Пожалуйста введите " . $attr;
            Validator::$error_fields[] = $attr;
        }
        elseif (!is_numeric($number)){
            Validator::$errors[] = "Поле " . $attr .
                                   " может содержать только цифры";
            Validator::$error_fields[] = $attr;
        }
    }

    private static function validateEmail($email){
        if (strlen($email) > 0) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Validator::$errors[] = "Поле Email заполнено не правильно. 
                                        Правильный формат: example@mail.com";
                Validator::$error_fields[] = "Email";
            }
        }
    }

    private static function validateUniqueEmail($email, $ADG){

       $update = isset($_COOKIE['abt_pass']) ? true : false; 

        if ($ADG->isUniqueEmail($email, $update) == 1){
            //do nothing
        }
        else{
            Validator::$errors[] = "Такой Email уже существует";
            Validator::$error_fields[] = "Email";
        }
    }

    private static function validatePoints($points){
        if (is_numeric($points)){
            if ($points < 0){
                Validator::$errors[] = "Баллы не могут быть меньше 0";
                Validator::$error_fields[] = "Points";
            }
            elseif ($points > 200){
                Validator::$errors[] = "Баллы не могут быть больше 200";
                Validator::$error_fields[] = "Points";
            }
        }
    }

    private static function validateBirthYear($year){
        if (!is_numeric($year)){
            Validator::$errors[] = "Год может содержать только цифры";
            Validator::$error_fields[] = "Birth";
        }
        elseif ($year == ''){
            Validator::$errors[] = "Пожалуйста, введите год Вашего рождения";
            Validator::$error_fields[] = "Birth";
        }
        elseif (strlen($year) < 4){
            Validator::$errors[] = "Год рождения введен не правильно. Правильный формат: 1990";
            Validator::$error_fields[] = "Birth";
        }
        elseif ($y = (int)$year > getdate()['year']){
            Validator::$errors[] = "Год рождения не может быть в будущем";
            Validator::$error_fields[] = "Birth";
        }
        elseif ($y = (int)$year < 1900){
            Validator::$errors[] = "Год рождения не может быть раньше 1900";
            Validator::$error_fields[] = "Birth";
        }
        elseif (!checkdate(1, 1, $year)){
            Validator::$errors[] = "Год рождения введн не правильно";
            Validator::$error_fields[] = "Birth";
        }
    }

    private static function validatePhoto($photo){

        if ($photo){
            $ext = end(explode(".", $photo));

            if ($ext != 'jpg'){
                Validator::$errors[] = "Неправильное расширение файла фотографии (надо jpg). У вас - " .
                    htmlspecialchars($ext);
                Validator::$error_fields[] = "Photo";
            }
        }
        else{
            Validator::$errors[] = "Добавьте фотографию";
            Validator::$error_fields[] = "Photo";
        }


    }
    
    public static function dumpErrorsAndFields(){
        var_dump(Validator::$errors);
        var_dump(Validator::$error_fields);
    }
    
}