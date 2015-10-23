<?php
/*
* File: app.class.php
* Functions: Различные функции для блога
* Author: jadewizard
* Buryakov.su
*/

class application
{
    public function goToErrorPage($pageCode)
    {
        # code...
    }

    public function getBreadCrumbs()
    {
        global $twig, $post;
        
        $firstCrumb = null;
        $secondCrumb = null;
        $thirdCrumb = null;

        if(isset($_GET['p']))
        {
            if($_GET['p'] == "note")
            {
                $firstCrumb = array("title" => "Home", "url" => "/");
                $secondCrumb = array("title" => "Note", "url" => "/note");
                $thirdCrumb = null;

                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $title = $post->getPostTitle($id);

                    $thirdCrumb = array('title' => $title);
                }
            }

            $crumbsArray = array("firstCrumb" => $firstCrumb, "secondCrumb" => $secondCrumb, "thirdCrumb" => $thirdCrumb);

            //print_r($crumbsArray);
            $twig->addGlobal("crumbsArray", $crumbsArray);
        }
    }
}