<?php


    $connString = "mysql:host=localhost; dbname=WeatherOrNot_DB";
    $user="root";
    $pass="root";

    $pdo=new pdo($connString,$user,$pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//useful during initial development and debugging


