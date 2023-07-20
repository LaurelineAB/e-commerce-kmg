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
        $this->render('products/create.phtml', $this->cm->getAllCategories());
        if(isset($_POST['submit-new-product']))
        {
            $name = $_POST['name'];
            $picture = $_POST['picture'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $catID = $_POST['category'];
            $category = $this->cm->getCategoryById($catID);

            $product = new Product($name, $picture, $description, $price, $quantity, $category);
            $this->pm->createProduct($product);

            header("Location:index.php?route=homepage");
        }
    }

    // To have all the products by Category
    public function productsByCategory()
    {
        $id = $_GET['category_id'];
        $category = $this->cm->getCategoryById($id); // Put the id in parameter
        $products = $this->pm->getProductByCategory($category->getName()); // Put the name of the category in parameter
        $this->render('categories/category.phtml', $products);
    }
    
    //To get a product by its id
    public function getProductById(int $id)
    {
        $product = $this->pm->getProductById();
        return $product;
    }
}

?>