<?php

class OrderManager extends AbstractManager {

    public function saveOrder(Order $order): ?Order {
        // Récupérer les valeurs de l'objet Order pour l'insertion dans la base de données
        $orderId = $order->getId();
        $date = $order->getDate()->format('Y-m-d H:i:s');
        $productId = $order->getProductId()->getId();
        $userId = $order->getUser()->getId();
        $totalPrice = $order->getTotalPrice();

        // Exemple de requête d'insertion SQL
        $query = $this->db->prepare("INSERT INTO orders (date, user_id, product_id, total_price) VALUES ( :date, :user_id, :product_id, :total_price)");
        
        $parameters = [
                'date' => $date,
                'user_id' => $userId,
                'product_id' => $productId,
                'total_price' =>$totalPrice
            ];
        
        $result = $query->execute($parameters);
        $order->setId($this->db->lastInsertId());
        if ($result) {
            return $order; // Retourner l'objet Order si la sauvegarde a réussi
        } else {
            return null; // Retourner null si la sauvegarde a échoué
        }
    }


    public function getOrderById(int $orderId): ?Order {
      
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $parameters = [
                'id' => $orderId
            ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($result !== false) 
        {
            date_default_timezone_set('Europe/Paris');
            $date = date('d m y h:i:s');
            $productId = $this->getProductById($result['product_id']); // Méthode à implémenter pour récupérer un produit par son ID
            $userId = $this->getUserById($result['user_id']); // Méthode à implémenter pour récupérer un utilisateur par son ID
            $totalPrice = $result['total_price'];
            $order = new Order($date, $productId, $userId, $totalPrice);
            return $order;
        }
        
        return null; // La commande n'a pas été trouvée, on retourne null
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

        $stmt = $this->db->prepare($sql);
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

        $query = $this->db->prepare("SELECT * FROM orders");
        $query->execute();

        $results = $query->fetch(PDO::FETCH_ASSOC);
        $arrayOrders = [];
        
        foreach($results as $order)
        {
            $order = new Order($order['id'], $order['date'], $this->getUserById($row['user_id']), $this->getProductById($row['product_id']), $order['total_price']);
            //Ne comprend pas getUserById
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