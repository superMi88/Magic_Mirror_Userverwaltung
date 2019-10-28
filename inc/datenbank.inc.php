<?php

$optionen = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
];

try
{
    $db = new PDO(
        'mysql:host=localhost;dbname=user_verwaltung',
        'adminer', //username adminer
        'Test1234', //passwort adminer
        $optionen
    );
}
catch(Exception $e)
{
    echo "Fehler: " . $e;
}

$db->query('SET NAMES utf8');