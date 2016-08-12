<?php
/**
 * Создает представление главной страницы сайта
 *
 * Данный файл контрлоирует вывод списка абитуриентов на главной странице сайта
 * за счет подключения соответствующих представлений
 * и установления определенных параметров в зависимости от которых
 * инициируется поиск либо формируется список всех абитуриентов.
 * В зависимости от действий пользователя, записи списка представляется ему
 * в определенном порядке.
 * Является входной точкой в приложение.
 */
require_once ("../app/init.php");

if (isset($_COOKIE['abt_pass'])){
    $is_new = 'Редактировать';
    $abt_id = $ADG->getIdByPass($_COOKIE['abt_pass']);
    $link = LinkMaker::makeRegLink("registered", $abt_id);
}
else{
    $is_new = 'Зарегистрироваться';
    $link = LinkMaker::makeRegLink("newbie");
}

    
$abiturientList = null;
$pagenator = null;
$orderBy = null;
$sorted = null;
$link_list = null;

    if (!isset($_GET['page'])) {
        $pagenator = new Pagenator(1, $ADG);
    }
    else{
        $pagenator = new Pagenator($_GET['page'], $ADG);
    }
    
    if (isset($_GET['orderBy'])){
        $orderBy = $_GET['orderBy'];
    }
    else{
        $orderBy = "abt_points";
    }

    if (isset($_GET['sorted'])){
        $sorted = $_GET['sorted'];
    }
    else{
        $sorted = "DESC";
    }
    
    //    
    //SELECT DATA FROM DATABASE
    //
if (isset($_GET['search'])){
    //
    //
    //SEARCH ENGINE
    //
    //SELECT DATA FROM USER SEARCH QUERY
    //
    //
    
    $searchGo = true;
    
    $highlight = ""; //CSS CLASS HIGHLIGHT SEARCH RESULT

    $search_query = htmlspecialchars($_GET['search_query']);

    UserQueryAnalyser::analyse($search_query);
        
    if(UserQueryAnalyser::$validQuery) {

        $abiturientList = $ADG->searchAbiturients($pagenator, $orderBy, $sorted, UserQueryAnalyser::$analysedUserQuery);
        
        $highlight = "highlight";

        $query_link_string = "&search_query=" . $_GET['search_query'] . "&" .
            "search=" . $_GET['search'] . "#";

        $nextPage = LinkMaker::makePageLinks($pagenator, $orderBy, $sorted, $query_link_string )['next'];
        $prevPage = LinkMaker::makePageLinks($pagenator, $orderBy, $sorted, $query_link_string )['prev'];

        $link_list = LinkMaker::makeLinkList($pagenator, $orderBy, $sorted, $query_link_string );

        $search_result = $ADG->countUserQueryRows;

    }
    else{
        $pagenator->total_pages = 0;
    }

}
else{
    //SELECT FULL LIST OF ABITURIENTS
    //
    //

    $searchGo = false;

    $abiturientList = $ADG->getAbiturientList($pagenator, $orderBy, $sorted);
    Secure::secureInput($abiturientList);

    $nextPage = LinkMaker::makePageLinks($pagenator, $orderBy, $sorted)['next'];
    $prevPage = LinkMaker::makePageLinks($pagenator, $orderBy, $sorted)['prev'];

    $link_list = LinkMaker::makeLinkList($pagenator, $orderBy, $sorted);
}
    
//close DB connect
closeDB($con, $ADG);

$tmp = "abiturient_list.html";

include_once "../views/main.html";
