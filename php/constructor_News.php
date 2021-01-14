<?php
require_once 'News.php';
class constructor_News extends News
{
    private function getShortNewsList(){
        return $this->query("SELECT * FROM `shortnews` LIMIT 0, 15");
    }
    //Отрисовываю короткие ссылки на главной стр
    public function constructShortNewsList(){
        $newsList = $this->getShortNewsList();
        $html = "";
        for ($i = 0; $i < count($newsList); $i++){
            $news = $newsList[$i];
            $html .= "<div class='block-news__short'>";
            $html .= "<p class='title'>".$news['title']."</p>";
            $html .= "<a href='/view.php?id=".$news['id_newsRBC']."'>Подробнее</a>";
            $html .= "<a href='".$news['original_link']."' target='_blank'>Оригинал</a>";
            $html .= "</div>";
        }
        return $html;
    }
}