<?php

/**
 * Class UserQueryAnalyser
 * 
 * @package app
 * @author sammmann
 * 
 * Класс занимается анализом валидности поискового запроса пользователя.
 * Если поле $validQuery принмает значение false во время анализа,
 * значит запрос не поступает в базу данных, а пользователь получает
 * сообщение об ошибке, сохраненное в поле $errorsInTheQuery.
 * 
 */
class UserQueryAnalyser{
    
    public static $analysedUserQuery = array();

    public static $validQuery = true;

    public static $errorsInTheQuery = "";

    private static $maxUserQueryLength = 2;

    public static function analyse($query)
    {
        if ($query == ""){
            UserQueryAnalyser::$errorsInTheQuery = "Пустой запрос";
            return UserQueryAnalyser::$validQuery = false;
        }
        else {

            $queryArr = explode(" ", trim(strval($query)));

            if (count($queryArr) > UserQueryAnalyser::$maxUserQueryLength) {
                UserQueryAnalyser::$errorsInTheQuery = "Длина запроса превышена (максимум " .
                    UserQueryAnalyser::$maxUserQueryLength . " слова). У вас " .
                    count($queryArr);
                return UserQueryAnalyser::$validQuery = false;
            }

            else {
                    UserQueryAnalyser::semanticAnalyse($queryArr);
                    return UserQueryAnalyser::$validQuery;
            }
        }

    }

    private static function semanticAnalyse($query)
    {

        $analysedUserQuery = count($query) == 2 ?
                             array('1' => $query[0], '2' => $query[1]) :
                             array('1' => $query[0]);

        $curr_string = 1;
        
        foreach ($analysedUserQuery as $string){
            UserQueryAnalyser::analyseString($string,
                                             $curr_string
                                             );
            if (!UserQueryAnalyser::$validQuery){
                break;
            }
            else{
                $curr_string++;
            }
        }

        UserQueryAnalyser::$analysedUserQuery = $analysedUserQuery;
    }

    private static function analyseString($string, $stringNumber)
    {
        if(mb_strlen($string) > 30){
            UserQueryAnalyser::$errorsInTheQuery .= "Превышена максимальная длина поисковой строки (30). " .
                                                    "У вас " . mb_strlen($string) .
                                                    " Ошибка в слове - " . $stringNumber . ". ";

            UserQueryAnalyser::$validQuery = false;
        }
        elseif (preg_match('/[^а-яА-Я\s-\']$/u', $string)){
            UserQueryAnalyser::$errorsInTheQuery .= "В поисковой строке могут присутствовать 
                                                            только русские буквы и апостроф. " .
                                                    "Ошибка в слове - " . $stringNumber . ". ";
            UserQueryAnalyser::$validQuery = false;
        }
        else{
            UserQueryAnalyser::$validQuery = true;
        }
    }
}