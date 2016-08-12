<?php

/**
 * Class HighLighter
 * 
 * @package app
 * @author sammmann
 * 
 * Отвечает за анализ и подсвечивание результатов поиска.
 * Подсвечивает красным либо красным и синем,
 * в зависимости от того, сколько слов ввел пользователь для поиска.
 */

class HighLighter{

    public static function highlight($string, $second = null){
        $userQuery = UserQueryAnalyser::$analysedUserQuery;

        if (count($userQuery) == 1){

            $text = $string;
            $mask = $userQuery['1'];
            return preg_replace("/($mask)/iu", '<span style=\'background-color:red;\'>$1</span>', $text);

        }
        elseif (count($userQuery) == 2){

            $text = $string;

            if (!$second){
                $maskOne = $userQuery['1'];
                return preg_replace("/($maskOne)/iu", '<span style=\'background-color:red;\'>$1</span>', $text);
            }
            else{
                $maskTwo = $userQuery['2'];
                return preg_replace("/($maskTwo)/iu", '<span style=\'background-color:aqua;\'>$1</span>', $text);
            }

        }
        else{
            return "Ошибка в запросе";
        }
    }


}