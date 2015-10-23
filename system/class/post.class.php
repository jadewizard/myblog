<?php
/*
* File: pages.php
* Functions: Работа с постами
* Author: jadewizard
* Buryakov.su
*/

class post
{
    function __construct()
    {
        global $pdo,$twig;

        $resultArray = $pdo->query("SELECT * FROM articles");
        $postArray = $resultArray->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($postArray); $i++)
        { 
            $postArray[$i]['content'] = substr(strip_tags($postArray[$i]['content']), 0 ,270);
            $postArray[$i]['content'] = substr($postArray[$i]['content'], 0, strrpos($postArray[$i]['content'], ' ')).'...';
            //В данном цикле обрезаем превью текст,
            //до 270 символов, затем убираем пробел в конце и проставляем ...
        }

        $twig->addGlobal("postArray",$postArray);
    }

    public function getPostById($id)
    {
        global $pdo, $twig;

        $resultArray = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $resultArray->execute(array($id));

        $twig->addGlobal("resultArray",$resultArray->fetchAll(PDO::FETCH_ASSOC)[0]);
    }

    public function getPostTitle($id)
    {
        global $twig, $pdo;

        $resultArray = $pdo->prepare("SELECT title FROM articles WHERE id = ?");
        $resultArray->execute(array($id));

        $title = $resultArray->fetchAll(PDO::FETCH_ASSOC);

        return $title[0]['title'];
    }
}