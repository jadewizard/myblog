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
        global $pdo,$twig,$pgManager;

        $resultArray = $pdo->query("SELECT * FROM articles");
        $postArray = $resultArray->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($postArray); $i++)
        { 
            $postArray[$i]['content'] = substr(strip_tags($postArray[$i]['content']), 0 ,270);
            $postArray[$i]['content'] = substr($postArray[$i]['content'], 0, strrpos($postArray[$i]['content'], ' ')).'...';
            //В данном цикле обрезаем превью текст,
            //до 270 символов, затем убираем пробел в конце и проставляем ...
        }

        $expPostArray = $this->expArray($postArray);

        $twig->addGlobal("postArray",$expPostArray);

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

    public function expArray($inputArray)
    {
        global $pgManager;

        $pagesCount = ceil(count($inputArray) / $pgManager->postCount);
        // MAX возможное кол-во страниц.

        $expArray = array_chunk($inputArray, $pgManager->postCount);
        // Разбиваем массив на подмассивы, для пагинации.
        // Индекс массива == # странцы.

        if(isset($_GET['n']))
        {
            $currentPage = $_GET['n'];
            // Текущая страница

            if($currentPage <= $pagesCount) // Проверяем на наличе текущей странице в массиве
            {
                if(preg_match("/[0-9]/", $currentPage))
                {
                    return $expArray[$currentPage - 1];
                }
            }
            else
            {
                echo "Not defined";
                // Такой страницы нет.
            }
        }
        else
        {
            return $expArray[0];
        }
    }
}