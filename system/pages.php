<?php
/*
* File: pages.php
* Functions: Работа со страницами сайта
* Author: jadewizard
* Buryakov.su
*/

if(isset($_GET['p']))
{
    $twig->addGlobal("currentPage", $_GET['p']);
    //Текущая страница

    switch ($_GET['p'])
    {
        case 'note':
            $content = "singlepost.html";
            break;
        case 'adminpanel':
            $content = "adminpanel.html";
            break;
    
        default:
            $content = 'singlepost.html';
            break;
    }

    if($_GET['p'] == "note" && isset($_GET['id']))
    {
        //Если только цифры
        if(preg_match("/[0-9]/", $_GET['id']))
        {
            $id = $_GET['id']; //берём id
            $post->getPostById($id); //получаем пост
            $content = 'fullpost.html';
        }
    }

    if($_GET['p'] == "adminpanel" && isset($_GET['a']))
    {
        if($_GET['a'] == "add")
        {
            $adminContent = "newpost.html";
        }
        elseif($_GET['a'] == "edit")
        {
            $adminContent = "editlist.html";
        }
        else
        {
            $adminContent = "404.html";
        }
    }
}
else
{
    $content = 'singlepost.html';
    $twig->addGlobal("currentPage", "main");
}

$template = $twig->loadTemplate('index.html');

echo $template->render(array("content" => $content,
                             "adminContent" => $adminContent,
                             "search" => 'search.html',
                             "way" => 'way.html',
                             'header' => 'header.html'));

$loader = new Twig_Loader_String();