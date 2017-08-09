<?php

ini_set('display_errors', 1);
session_start();
define('ROOT', dirname(__FILE__).'/application');
require_once(ROOT.'/Router.php');

$router = new Route();
$router->start();
