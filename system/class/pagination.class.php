<?php

class pagination
{
    public $inputArray; // Массив с контентом изначальный
    public $postArray; // Массив с контетном /* после разбиенеия */
    public $postCount; // Кол-во записей на странице
    public $pageCount;
    public $pagesArray = array(
                         "current" => null,
                         "next" => null,
                         "prev" => null,
                         "pageCount" => null); // Массив с ссылками на страницы

    public function __construct()
    {
        global $pdo;

        $data = $pdo->query("SELECT id FROM articles")->fetchAll(PDO::FETCH_ASSOC);
        // Получим ID из БД, что бы подсчитать кол-во возможных страниц
        $this->postCount = 4;
        // Кол - во записей выводимых на странице

        $this->pageCount = ceil(count($data) / $this->postCount);
        // MAX возможное кол-во страниц на сайте

        $this->pagesArray["pageCount"] = $this->pageCount;
    }

    public function getLinks()
    {
        global $twig;

        if(isset($_GET['n']))
        {
            $currentPage = $_GET['n'];
            // Текущая страница

            if(preg_match("/[0-9]/", $currentPage)) // Только цифры
            {
                $this->pagesArray['current'] = $currentPage;
                // Текущая страница

                if($this->pagesArray['current'] < $this->pageCount) // Если текущая страница < MAX страницы
                {
                    $this->pagesArray['next'] = $this->pagesArray['current'] + 1;
                    // Следующая страница
                }

                if($this->pagesArray['current'] != 1) // Если текущая стараниц НЕ 1
                {
                    $this->pagesArray['prev'] = $this->pagesArray['current'] - 1;
                    // Предыдущая страница
                }

                $twig->addGlobal("pagesArray", $this->pagesArray);
            }
        }
    }
}