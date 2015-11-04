<?php
/*
* File: engine.php
* Functions: Старт всех служб и подключение других файлов
* Author: jadewizard
* Buryakov.su
*/

require_once 'db.php';
//Файл для соеденения с БД

require_once 'vendor/autoload.php';
//Подключаем шаблонизатор TWIG

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates'); //Путь к шаблону
$twig = new Twig_Environment($loader); //Инициализируем шаблонизатор

require_once 'class/pagination.class.php';
$pgManager = new pagination();
// Пагинация

require_once 'class/post.class.php';
$post = new post();
//Работа с постами на сайте

require_once 'class/app.class.php';
$application = new application();
//Различные функции сайта


$pgManager->getLinks();

$application->getBreadCrumbs();
// Хлебные крошки

require_once 'actionhandler.php';
//Обработка пользовательских действий

require_once 'pages.php'; 
//Работа со страницами сайта