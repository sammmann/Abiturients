<?php

/**
 * Class Tokenizer
 * 
 * @package app
 * @author sammmann
 * 
 * Класс, который создает 32 значный пароль для пользователя,
 * на основе набора $chars.
 * Чтобы изменить длину пароля, измените параметр $tokenLength.
 * 
 */
class Tokenizer{

    private static $tokenLength = 32;

    public static function makeNewToken(){

        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';

        $numChars = strlen($chars);

        $token = '';

        for ($i = 0; $i < Tokenizer::$tokenLength; $i++) {
            $token .= substr($chars, rand(1, $numChars) - 1, 1);
        }

        return $token;
    }
    
}