<?php
/*
* File: db.php
* Functions: database connection
* Author: jadewizard
* Buryakov.su
*/

$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

$pdo = new PDO("mysql:dbname=blog;host=localhost;charset=utf8","root","211996dima",$options);