<?php

/**
 * Class Pagenator
 * 
 * @package app
 * @author sammmann
 * 
 * Отвечает за формирование страниц дял постраничной навигации на сайте.
 * Хранит текущую страницу, общее количество страниц в текущей выборке данных,
 * общее количество записей в текущей выборке данных.
 * 
 * Для того, чтобы изменить количество записей отображаемых на однйо странице,
 * необходимо изменить поле: $rows_per_page
 */

class Pagenator{

    public $ADG = null;

    public $curr_page = 1;

    public $rows_per_page = 5;

    public $total_pages = 0;

    public $total_rows = 0;

    public $pagesOnScreen = "";

    public function __construct($curr_page, $ADG)
    {
        $this->curr_page = $curr_page;
        $this->total_rows = $ADG->totalAbiturients();
        $this->pageSelector();
    }
    
    public function start(){
        return (($this->curr_page - 1) * $this->rows_per_page);
    }
    
    public function nextPage()
    {
        if ($this->curr_page == $this->total_pages){
            return 1;
        }
        else {
            return $this->curr_page + 1;
        }
    }

    public function prevPage()
    {
        if ($this->curr_page == 1){
            return $this->total_pages;
        }
        else {
            return $this->curr_page - 1;
        }
    }

    private function pageSelector(){
        if ($this->total_rows > $this->rows_per_page){
            $this->pagesOnScreen = "pagenator.html";
            $this->total_pages = ceil($this->total_rows/$this->rows_per_page);
        }
    }

}