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
                // $this->productController->indexOfProducts();
            }
            if($_GET['route'] === "register")
            {
                $this->userController->createUser();
            }
            else if($_GET['route'] === "edit-user")
            {
                $this->userController->editUser();
            }
            else if($_GET['route'] === "login")
            {
                $this->userController->read();
            }
            else if($_GET['route'] === "Category-products")
            {
                $this->productController->indexOfProducts();
            }
            else if ($_GET['route'] === "create-product")
            {
                $this->productController->createProduct();
            }
            else if($_GET['route'] === "create-category")
            {
                $this->categoryController->createCategory();
            }
            else if($_GET['route'] === "category" && isset($_GET['category_id']))
            {
                $this->productController->productsByCategory();
            }
            else if($_GET['route'] === "product" && isset($_GET['product_id']))
            {
                $product = $this->productController->getProductById($_GET['product_id']);
                $this->productController->render("products/product.phtml", [$product]);
            }
        }
        else
        {
            $this->categoryController->getAllCategories();
            // $this->productController->indexOfProducts();
        }
    }
}

?>