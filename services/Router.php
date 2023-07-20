<?php

class Router {
    private UserController $userController;
    private ProductController $productController;
    private OrderController $orderController;
    private CategoryController $categoryController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->productController = new ProductController();
        $this->orderController = new OrderController();
        $this->categoryController = new CategoryController;
    }
    public function checkRoute()
    {
        if(isset($_GET['route']))
        {
            if($_GET['route'] === "homepage")
            {
                $this->categoryController->getAllCategories();
                $this->productController->indexOfProducts();
            }
            if($_GET['route'] === "create-user")
            {
                $this->userController->createUser();
            }
            else if($_GET['route'] === "edit-user")
            {
                $this->userController->editUser();
            }
            else if($_GET['route'] === "login")
            {
                $this->userController->read($_SESSION['user_id']);
            }
            else if($_GET['route'] === "Category-products")
            {
                $this->productController->productsByCategory();
            }
            else if($_GET['route'] === "create-category")
            {
                $this->categoryController->createCategory();
            }
        }
        else
        {
            $this->categoryController->getAllCategories();
            $this->productController->indexOfProducts();
        }
    }
}

?>