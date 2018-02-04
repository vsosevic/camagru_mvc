<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
session_start();
require_once(ROOT.'/components/Router.php');
require_once(ROOT.'/components/DBConnection.php');
include_once (ROOT . '/views/layouts/header.php');
$router = new Router;
$router->run();
include_once (ROOT . '/views/layouts/footer.php');
