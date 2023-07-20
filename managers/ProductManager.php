<?php

class ProductManager extends AbstractManager {

    // To get all the categories in an array
    public function getAllProducts() : array
    {
        $query=$this->db-prepare("SELECT * FROM products");
        $query->execute();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    // Create a product and send it in the database
    public function createProduct(Product $product) : Product
    {
        $query=$this->db->prepare("INSERT INTO products (product_name, picture, description, price, quantity, category_id)
                  VALUES (:name, :picture, :description, :price, :quantity, :category)");
        $parameters = [
            'name' => $product->getName(),
            'picture' => $product->getPicture(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'category' => $product->getCategory()->getId()
        ];

        $query->execute($parameters);
        $id = $query->fetch(PDO::FETCH_ASSOC);
        $product->setId($this->db->lastInsertId());

        return $product;
    }

    // If we want to edit a product
    public function editProduct(Product $product) : void
    {
        $query=$this->db->prepare("UPDATE products SET product_name = :name, pictures = :picture, description = :description, price = :price, quantity = :quantity, category_id = :category");
        $parameters = [
            'name' => $product->getName(),
            'picture' => $product->getPicture(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'category' => $product->getCategory()->getId()
        ];
        $query->execute($parameters);
    }

    // To find the Product by its id
    public function getProductById(int $id) : Product
    {
        $query=$this->db->prepare("SELECT * FROM products WHERE products.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);

        $newProd = new Product($product['product_name'], $product['pictures'], $product['description'], $product['price'], $product['quantity'], $product['category_id']);

        return $newProd;
    }

    // To delete a Product by its id
    public function deleteProduct(int $id) : void
    {
        $query=$this->db->prepare("DELETE FROM products WHERE products.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
    }

    // To find a Product by its name
    public function getProductByName(string $name) : Product
    {
        $query=$this->db->prepare("SELECT * FROM products WHERE product_name = :name");
        $parameters=['name' => $name];
        $query->execute($parameters);

        $result=$query->fetch(PDO::FETCH_ASSOC);
        $product = new Product($result['product_name'], $result['pictures'], $result['description'], $result['price'], $result['quantity'], $result['category_id']);

        return $product;
    }

    // To get all the products from a same category
    public function getProductByCategory(string $name) : array
    {
        $query=$this->db->prepare("SELECT * FROM products JOIN categories ON products.category_id = categories.id
            WHERE categories.category_name = :name");
        $parameters=['name' => $name];
        $query->execute($parameters);

        $list = $query->fetchAll(PDO::FETCH_ASSOC);

        return $list;
    }
}

?>