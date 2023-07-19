<?php

class CategoryManager extends AbstractManager {

    // To get all categories
    public function getAllCategories() : array
    {
        $query=$this->db->prepare("SELECT * FROM categories");
        $query->execute();
        $array=$query->fetch(PDO::FETCH_ASSOC);

        return $array;
    }

    public function createCategory(Category $category) : Category
    {
        $query=$this->db->prepare("INSERT INTO categories (category_name, product_id, description)
                            VALUES (:name, :product, :description)");
        $parameters=[
            'name' => $category->getName(),
            'product' => $category->getProduct()->getId(),
            'description' => $category->getDescription()
        ];
        $query->execute($parameters);
        $id=$query->fetch(PDO::FETCH_ASSOC);
        $category->setId($this->db->lastInsertId());

        return $category;
    }

    // To get a category by its id
    public function getCategoryById(int $id) : Category
    {
        $query=$this->db->prepare("SELECT * FROM categories WHERE categories.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $newCat = new Category($result['category_name'], $result['description']);

        return $newCat;
    }

    public function editCategory(Category $category) : void
    {
        $query=$this->db->prepare("UPDATE categories SET category_name = :name, description = :description");
        $parameters=[
            'name' => $category->getName(),
            'description' => $category->getDescription()
        ];
        $query->execute($parameters);
    }

    public function deleteCategory(int $id) : void
    {
        $query=$this->db->prepare("DELETE FROM categories WHERE categories.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
    }
}

?>