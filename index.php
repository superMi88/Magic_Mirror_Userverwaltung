<?php

require_once 'inc/funktionen.inc.php';

spl_autoload_register('autoloadControllers');
spl_autoload_register('autoloadEntities');
spl_autoload_register('autoloadTraits');

//Datenbankverbindung
require_once 'inc/datenbank.inc.php';
Betreuer::verbindeZuDb($db);
Klient::verbindeZuDb($db);
Nachricht::verbindeZuDb($db);

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerName = ucfirst($controller) . 'Controller';

//Wenn der controller nicht existiert benutze den IndexController
if(!class_exists($controllerName)) {
    $controllerName = 'IndexController';
}

session_set_cookie_params(2592000);
session_start();

//Wenn die action im Controller nicht existiert setze die action auf 'index'
if(!file_exists('templates/' . $controllerName . '/' . $action . 'Action.tpl.php')){
    //$action = 'index';
    redirect('index.php');
}

$requestController = new $controllerName();
$requestController->run($action);