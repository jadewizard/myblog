<?php
/*
* File: pages.php
* Functions: Обработка URL.
* Author: jadewizard
* Buryakov.su
*/

if($_GET['p'] == "adminpanel" && isset($_GET['a']))
{
    if(isset($_GET['a']) == "edit" && isset($_GET['id']))
    {
        /*
        Если пользователь находится на странице
        с редактированьем поста, то берём ID этого поста
        и получаем из БД его данные.
        */
        $id = $_GET['id'];
        $post->getPostById($id);
    }
}