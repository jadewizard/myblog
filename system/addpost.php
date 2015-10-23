<?php
/*
* File: addpost.php
* Functions: Добавление постов на сайт
* Author: jadewizard
* Buryakov.su
*/

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$pdo = new PDO("mysql:dbname=blog;host=localhost;charset=utf8","root","123",$opt);

/*
===================== ПОЯСНЕНИЕ ==========================
* Если текущее действие ($_POST['action']) - это
* добавление (add), то выполняем функцию добавления в БД
* Если текущее действие обновление (update), то просто
* получаем ID, только что доавбленного поста (MAX ID в БД)
* и обновляем строки с этим ID.
==========================================================
*/
if($_POST['action'] == 'add')
{
    $title = $_POST['postTitle'];
    $text = $_POST['postText'];

    $addQuery = $pdo->prepare("INSERT INTO articles (title,content) VALUES (:title, :content)");
    $addQuery->execute(array("title" => $title, "content" => $text));
}
elseif ($_POST['action'] == "update")
{
    $title = $_POST['postTitle'];
    $text = $_POST['postText'];

    $lastIdArray = $pdo->query("SELECT MAX(id) FROM articles")->fetchAll(PDO::FETCH_ASSOC)[0];
    $lastId = $lastIdArray['MAX(id)'];

    $addQuery = $pdo->prepare("UPDATE articles SET title = :title, content = :content WHERE id = :lastId");
    $addQuery->execute(array("title" => $title, "content" => $text, "lastId" => $lastId));
}