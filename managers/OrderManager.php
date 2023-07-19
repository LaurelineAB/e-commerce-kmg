<?php

class OrderManager extends AbstractManager {

    public function saveOrder(Order $order): ?Order {
        // Récupérer les valeurs de l'objet Order pour l'insertion dans la base de données
        $orderId = $order->getId();
        $date = $order->getDate()->format('Y-m-d H:i:s');
        $productId = $order->getProduct()->getId();
        $userId = $order->getUser()->getId();
        $price = $order->getPrice();

        // Exemple de requête d'insertion SQL
        $sql = "INSERT INTO orders (id, date, product_id, user_id, price) VALUES (?, ?, ?, ?, ?)";

        // Préparer la requête avec la connexion à la base de données
        $stmt = $this->db()->prepare($sql);

        // Binder les valeurs aux paramètres de la requête
        $stmt->bind_param("issid", $orderId, $date, $productId, $userId, $price);

        // Exécuter la requête
        $result = $stmt->execute();
        if ($result) {
            return $order; // Retourner l'objet Order si la sauvegarde a réussi
        } else {
            return null; // Retourner null si la sauvegarde a échoué
        }
    }


    public function getOrderById(int $orderId): ?Order {
        $sql = "SELECT id, date, product_id, user_id, price FROM orders WHERE id = ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            return null; // La commande n'a pas été trouvée, on retourne null
        }

        // Construire l'objet Order à partir des données de la base de données
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
        $product = $this->getProductById($row['product_id']); // Méthode à implémenter pour récupérer un produit par son ID
        $user = $this->getUserById($row['user_id']); // Méthode à implémenter pour récupérer un utilisateur par son ID
        $price = $row['price'];

        return new Order($row['id'], $date, $product, $user, $price);
    }

    public function getAmountProduct(int $order_id): ?int {
        $sql = "SELECT COUNT(*) as amount FROM product_order WHERE order_id = ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $amount = $row['amount'];
        } else {
            $amount = null;
        }

        return $amount;
    }

    public function getTotalPrice(int $order_id): float {
        $sql = "SELECT SUM(products.price) as total_price FROM products JOIN product_order ON products.id = product_order.product_id WHERE product_order.order_id = ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $totalPrice = (float) $row['total_price'];
        } else {
            $totalPrice = 0.0;
        }

        return $totalPrice;
    }

    public function getAllOrders(): ?array {
        $sql = "SELECT * FROM orders";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $arrayOrders = array();

        while ($row = $result->fetch_assoc()) {
            $order = new Order($row['id'], new DateTime($row['date']), $this->getProductById($row['product_id']), $this->getUserById($row['user_id']), $row['price']);
            $arrayOrders[] = $order;
        }

        return $arrayOrders;
    }

    public function getOrderByUser(User $user): ?array {
        $sql = "SELECT * FROM orders WHERE user_id = ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bind_param("i", $user->getId());
        $stmt->execute();

        $result = $stmt->get_result();

        $arrayOrders = array();

        while ($row = $result->fetch_assoc()) {
            $order = new Order($row['id'], new DateTime($row['date']), $this->getProductById($row['product_id']), $this->getUserById($row['user_id']), $row['price']);
            $arrayOrders[] = $order;
        }

        return $arrayOrders;
    }
}
?>