<?php

class OrderManager extends AbstractManager {

    private UserManager $um;
    private ProductManager $pm;
    
    public function __construct()
    {
        $this->um = new UserManager();
        $this->pm = new ProductManager();
    }
    
    public function saveOrder(Order $order): ?Order {
        // Récupérer les valeurs de l'objet Order pour l'insertion dans la base de données
        $date = $order->getDate()->format('Y-m-d H:i:s');
        $userId = $order->getUser()->getId();
        $totalPrice = $order->getTotalPrice($order_id);

        // Exemple de requête d'insertion SQL
        $query = $this->db->prepare("INSERT INTO orders (date, user_id, total_price) VALUES ( :date, :user_id, :total_price)");
        
        $parameters = [
                'date' => $date,
                'user_id' => $userId,
                'total_price' =>$totalPrice
            ];
        
        $result = $query->execute($parameters);
        $order->setId($this->db->lastInsertId());
        if ($result !== false) {
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
            $userId = $this->um->getUserById($result['user_id']); // Méthode à implémenter pour récupérer un utilisateur par son ID
            $totalPrice = $result['total_price'];
            $order = new Order($date, $userId, $totalPrice);
            $order->setId($orderId);
            
            $query = $this->db->prepare("SELECT product_id FROM product_order WHERE order_id = :id");
            $parameters = [
                'id' => $orderId
            ];
            $query->execute($parameters);
            $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
            $products = [];
            foreach($fetch as $item)
            {
                $product = $this->pm->getProductById($item);
                $products[] = $product;
            }
            $order->setProducts($products);
            return $order;
        }
        
        return null; // La commande n'a pas été trouvée, on retourne null
    }

    public function getTotalPrice(int $order_id): float {
        
        //Retrieve all products with linked by the same order_id / product_id by calculating their total sum
        $query = $this->db->prepare("SELECT SUM(products.price) as price FROM products JOIN product_order ON products.id = product_order.product_id WHERE product_order.order_id = :order_id");
        
        $parameters = [ 'order_id' => $order_id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $totalPrice = 0.0;

        if($result !== false) {
            $totalPrice = (float) $result['total_price'];
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
            $order = new Order($order['id'], $order['date'], $this->getUserById($row['user_id']), $order['total_price']);
            //Ne comprend pas getUserById
            $arrayOrders[] = $order;
        }

        return $arrayOrders;
    }

    public function getOrdersByUser(User $user): ?array {
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE user_id = :id");

        $parameters = ['id' => $user->getId()];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $arrayOrders = array();

        foreach ($result as $orderUser) {
            $order = new Order($orderUser['date'], $this->getUserById($orderUser['user_id']), $orderUser['total_price']);
            $arrayOrders[] = $order;
        }

        return $arrayOrders;
    }
    
    // public function getOrderId($id)
    // {
    //     $query = $this->db->prepare("SELECT order_id FROM product_order WHERE order_id = :id ");
        
    //     $parameters = ['id' => $id];
    //     $order_id = $query->fecth(PDO::FETCH_ASSOC);
        
    //     return $order_id;
        
    // }
}
?>