<?php

// session_start();

require 'services/autoload.php';

$um = new UserManager();
$pm = new ProductManager();
$cm = new CategoryManager();
$om = new OrderManager();

$uc = new UserController($um);
$pc = new ProductController($pm);
$cc = new CategoryController($cm);
$oc = new OrderController($om);

// require 'services/Router.php';
$router = new Router();
$router->checkRoute();



?>