<?php

require_once '../php/News.php';

class Parser
{
    private $news = null;

    public function __construct()
    {
        //Объект класса, который работает с новостям
        $this->news = new News();
    }

    //Беру данные с стр и возвращаю из обратно
    public function getContent($link = 'https://www.rbc.ru/')
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $link);
        curl_setopt($curl_handle, CURLOPT_HEADER, 0);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $query;
    }

    public function getLinkLongNews()
    {
        $query = $this->news->getNewsIdRBC($_POST['id']);
        return $query[0]['original_link'];
    }

    public function shortLinks($content) : void
    {
        for ($i = 0; $i < count($content); $i++) {
            $this->news->insertShortNews($content[$i]);
        }
    }
    //Просто перенаправляю
    public function longNews()
    {
        print_r($this->news->workWithLongNews());
    }
}