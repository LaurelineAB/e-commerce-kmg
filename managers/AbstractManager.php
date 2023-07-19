<?php

abstract class AbstractManager {
    protected PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            $connexionString = "mysql:host=db.3wa.io;port=3306;dbname=francisrouxel_e-commerce",
            $username = "francisrouxel",
            $password = "acadbb28886b6985666cd7eff4651f1d"
        );
    }
}

?>