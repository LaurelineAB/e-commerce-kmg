<?php
// All the requires will be here and this file will be required on index.php

require './models/User.php';
require './models/Category.php';
require './models/Product.php';
require './models/Order.php';

session_start();

require './managers/AbstractManager.php';
require './managers/CategoryManager.php';
require './managers/UserManager.php';
require './managers/ProductManager.php';
require './managers/OrderManager.php';

require './controllers/AbstractController.php';
require './controllers/UserController.php';
require './controllers/ProductController.php';
require './controllers/CategoryController.php';
require './controllers/OrderController.php';

require 'Router.php';

?>