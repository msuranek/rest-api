<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Router\Router;
use Controllers\ApiController;

// Jednoduchý router jako v předchozím příkladu (musíš mít Router třídu)

$router = new Router();

$apiController = new ApiController();

// Zaregistrujeme routy přes reflexi
$router->registerController($apiController);

// Spustíme router (vybere správnou metodu a zavolá ji)
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

