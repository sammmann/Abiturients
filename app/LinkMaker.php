<?php

/**
 * Class LinkMaker
 * 
 * @package app
 * @author sammmann
 * 
 * Класс формирующий ссылки для навигации и осортировуи списка абитуриентов.
 * Параметр $searchString поступает извне в том случае, если пользователь инициировал поиск.
 * По умолчанию данный параметр принимает значение null (поиск не инициирован).
 * Остальные параметры указывают на порядок сортировки,
 * экземпляр класса Pagenator хранит общее колличество страниц списка,
 * а также указывает на текущую страницу.
 */

class LinkMaker{
    
    public static function makeRegLink($param, $id=null){
        switch ($param){
            case "newbie":{
                return "register.php?abiturient=newbie";
            }
            case "registered":{
                return "register.php?abiturient=registered&id=" .
                        urldecode($id);
            }
            default: 
                return "?link_err";    
        }
    }
    
    public static function makePageLinks(Pagenator $pagenator, $orderBy, $sorted, $searchString=null){
        $linkList = array
        (
            "next" => 'index.php?' . http_build_query([
                'sorted' => $sorted,
                'orderBy' => $orderBy,
                'page' => $pagenator->nextPage()]) . urldecode($searchString),
            "prev" => "index.php?" . http_build_query([
                    'sorted'  => $sorted,
                    'orderBy' => $orderBy,
                    'page' =>  $pagenator->prevPage()]) . urldecode($searchString)
        );

        return $linkList;
    }

    public static function addSearchString($linkList, $searchString){
        $linkList['next'] = $linkList['next'] . urldecode($searchString);
        $linkList['prev'] = $linkList['prev'] . urldecode($searchString);
        return $linkList;
    }
    
    public static function makeOrderByLink($orderBy, Pagenator $pagenator, $searchString=null){

            return "index.php?" . http_build_query([
                'orderBy' => $orderBy,
                'page' => $pagenator->curr_page]) . urldecode($searchString);


    }
    
    public static function makeSortLinkAsc(Pagenator $pagenator, $orderBy, $searchString=null){

            return "index.php?" . http_build_query([
                'sorted' => 'ASC',
                'orderBy' => $orderBy,
                'page' => $pagenator->curr_page]) . urldecode($searchString);


    }

    public static function makeSortLinkDesc(Pagenator $pagenator, $orderBy, $searchString=null){

            return "index.php?" . http_build_query([
                'sorted' => 'DESC',
                'orderBy' => $orderBy,
                'page' => $pagenator->curr_page]) . urldecode($searchString);

    }

    public static function makeLinkList(Pagenator $pagenator, $orderBy, $sorted, $searchString=null){
        $links = array();

            for ($i = 1; $i <= $pagenator->total_pages; $i++){
                $links[] = "index.php?" . http_build_query([
                        'sorted' => $sorted,
                        'orderBy' => $orderBy,
                         'page' => $i]) . urldecode($searchString);
            }

        return $links;

    }
}