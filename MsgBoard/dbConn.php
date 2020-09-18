<?php
    $db = new PDO("mysql:host=localhost;dbname=RD5_db;port=8889", "root", "root");
    $db->exec("set names utf8");