<?php

abstract class AbstractManager {
    protected PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            $connexionString = "mysql:host=db.3wa.io;port=3306;dbname=marierichir_ecommerce",
            $username = "marierichir",
            $password = "a616eefc0b8af8e5fb785ae6b42c19f1"
        );
    }
}

?>