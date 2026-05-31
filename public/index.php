<?php


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once "../app/core/Router.php";
require_once "../app/core/Controller.php";
require_once "../app/core/Database.php";
require_once "../app/core/Middleware.php";

$router = new Router();
$router->route();