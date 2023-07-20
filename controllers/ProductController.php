<?php

class ProductController extends AbstractController {
    private ProductManager $pm;
    private CategoryManager $cm;

    public function __construct()
    {
        $this->pm = new ProductManager();
        $this->cm = new CategoryManager();
    }

    // To show all the products on one page
    public function indexOfProducts()
    {
        $products = $this->pm->getAllProducts();
        $this->render('products/index.phtml', $products);
    }

    // To be able to create a product
    public function createProduct()
    {
        $this->render('products/create.phtml', []);
        if(isset($_POST['submit-new-product']))
        {
            $name = $_POST['name'];
            $picture = $_POST['picture'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $catID = $_POST['category'];
            $category = $this->cm->getCategoryById($catId);

            $product = new Product($name, $picture, $description, $price, $quantity, $category);
            $this->pm->createProduct($product);

            header("Location:index.php?route=homepage");
        }
    }
    // To have all the products by Category
    public function productsByCategory(string $category)
    {
        $category = $this->cm->getCategoryById($id); // Put the id in parameter
        $products = $this->pm->getProductByCategory($category->getName()); // Put the name of the category in parameter
        $this->render('products/index.phtml', $products, $category);
    }
    
}

?>