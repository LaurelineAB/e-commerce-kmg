<?php

class CategoryController extends AbstractController {
    private CategoryManager $cm;

    public function __construct()
    {
        $this->cm = new CategoryManager();
    }

    public function getAllCategories()
    {
        $categories = $this->cm->getAllCategories();
        $this->render('categories/index.phtml', $categories);
    }

    public function createCategory()
    {
        $this->render('categories/create.phtml', []);
        if(isset($_POST['submit-new-category']))
        {
            $category = new Category($_POST['name'], $_POST['description']);
            $newCat = $this->cm->createCategory($category);
            header("Location:index.php?route=homepage");
        }
    }
    public function getCategoryById(int $id)
    {
        $category = $this->cm->getCategoryById($id);
        return $category;
    }
}

?>