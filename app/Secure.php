<?php

/**
 * Class Secure
 * 
 * Класс который отвечает за безопасный вывод инфомрации на экран.
 */
class Secure{

    public static function secureInput($val){
        foreach ($val as $abt){
            $abt->abt_name = htmlspecialchars($abt->abt_name);
            $abt->abt_second = htmlspecialchars($abt->abt_second);
            $abt->abt_group = htmlspecialchars($abt->abt_group);
            $abt->abt_email = htmlspecialchars($abt->abt_email);
            $abt->abt_points = htmlspecialchars($abt->abt_points);
            $abt->abt_birth_year = htmlspecialchars($abt->abt_birth_year);
        }
    }
}