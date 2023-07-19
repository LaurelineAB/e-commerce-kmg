<?php

session_start();

require 'services/autoload.php';

$um = new UserManager();
$pm = new ProductManager();
$cm = new CategoryManager();
$om = new OrderManager();

$uc = new UserController($um);
$pc = new ProductController($pm);
$cc = new CategoryController($cm);
$oc = new OrderController($om);

if(isset($_GET['route']))
{
    require 'services/Router.php';
    $router = new Router($uc, $pc, $cc, $oc);
    $router->checkRoute();
}



?>