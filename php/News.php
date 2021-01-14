<?php

require_once 'DataBase.php';

class News extends DataBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Начало блока для работы с короткими новостями
     */
    //Проверка, есть ли такая новость в бд
    public function issetShortNews($id)
    {
        $query = $this->query('SELECT * FROM `shortnews` WHERE `id_newsRBC` = "' . $id . '";');
        return !empty($query);
    }

    //Добавление короткой новости в бд, если дубля нет
    public function insertShortNews($news)
    {
        //Проверяю, есть ли эта новость в бд, если нет иду дальше
        if ($this->checkShortNews($news)) return;

        //вырезаю ненужное из id и ссылки, убераю пробелы из тайтла
        $news['id'] = str_replace('id_newsfeed_', '', $news['id']);
        $news['link'] = str_replace('?from=newsfeed', '', $news['link']);
        $news['title'] = trim($news['title']);

        //Если все хорошо, тогда добавляю короткую новость в бд
        $this->query("INSERT INTO `shortnews` (`id_shortNews`, `id_newsRBC`, `title`, `original_link`) 
        VALUES ('0', '" . $news['id'] . "',  '" . $news['title'] . "', '" . $news['link'] . "');");
    }

    //Проверка короткой новости перед добавлением
    public function checkShortNews($news)
    {
        //        Проверка, есть ли ссылка
        if ($this->issetShortNews($news['id'])) {
            return true;
        };
        if (!$this->checkShortLink($news['link'])) {
            return true;
        };
    }

    //Проверка, чтобы новость была с сайта RBC
    private function checkShortLink($link)
    {
        return strripos($link, 'www.rbc.ru');
    }
    /**
     * Конец блока для работы с короткими новостями
     */


    /**
     * Начало блока для работы с большими новостям
     */
    //Входная функция view страницы
    public function workWithLongNews()
    {
        //Проверяю есть ли короткая новость по id КИС
        $link = $this->getNewsIdRBC($_POST['id']);
        //Ксли нету, тогда еррор
        $this->issetIDNewsRBC($link);

        //Проверяю, есть ли новость в бд, если нет добавляю, если есть, тогда беру из бд
        if ($this->issetLongNews($_POST['id'])) {
            $longNews = $this->query('SELECT * FROM `longNews` WHERE overview = "' . $_POST['id'] . '"');
            $longNews = $longNews[0];
            //Беру тело новости о добавляю к массиву, который обработается браузером
            $longNews['description'] = $this->query('SELECT description FROM `description` WHERE id_longNews = "' . $longNews['id_longNews'] . '"');
        } else {
            //Добавляю в бд
            $this->insertLongNews($link);
            //Добавляю текст в бд, после выношу массив
            $this->addPText($this->lastInsertId());

            $longNews = $_POST;
        }
        return json_encode($longNews);
    }


    //Проверка, существует ли в БД id с рбк
    private function issetIDNewsRBC($link)
    {
        if (empty($link)) {
            print_r(json_encode($error['error'] = 0));
            exit();
        }
    }

    //Получение короткой новости из БД по id RBC
    public function getNewsIdRBC($id)
    {
        return $this->query('SELECT * FROM shortnews WHERE `id_newsRBC` = "' . $id . '"');
    }

    //Добавление в бд текста большой новости
    public function addPText($id_news) : void
    {
        foreach ($_POST['description'] as $p) {
            if(empty(trim($p['description']))) continue;

            $this->query("INSERT INTO `description` (`id_longNews`, `description`) 
            VALUES ('" . $id_news . "', '" . $p['description'] . "');");
        }
    }

    // Добавление большой новости
    public function insertLongNews($link) : void
    {
        $this->query("INSERT INTO `longNews` (`id_shortnews`, `title`, `img`, `overview`) 
        VALUES ('" . $link[0]['id_shortNews'] . "',  '" . $_POST['title'] . "', '" . $_POST['img'] . "', '" . $_POST['id'] . "');");
    }

    //Проверка, есть ли большая новость
    public function issetLongNews($id)
    {
        $query = $this->query('SELECT * FROM `longnews` WHERE `overview` = "' . $id . '";');
        return !empty($query);
    }
    /**
     * Конец блока для работы с короткими новостями
     */

}