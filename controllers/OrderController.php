<?php

class OrderController extends AbstractController {

    public function __construct(){

        $this->orderManager = new Order();

    }

    public function createOrder(array $post){
    // Rendu de la vue "orders/create.phtml" avec le tableau $post
    $this->render('orders/create.phtml', $post);

        if(isset($_POST['add'])){
            $this->orderManager->saveOrder($post);
        }
    }

    public function getOrderById(){

    }

    public function getAmoutProduct(){

    }

    public function getTotalPrice (){

    }

    public function getAllOrders(){

    }

    public function getOrderByUser(){

    }
}

?>
