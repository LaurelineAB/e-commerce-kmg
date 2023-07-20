<?php

class OrderController extends AbstractController {

    public function __construct(){

        $this->orderManager = new OrderManager();

    }

    public function createOrder(array $post){
    // Rendu de la vue "orders/create.phtml" avec le tableau $post
    $this->render('orders/create.phtml', $post);

        if(isset($_POST['add'])){
            $this->orderManager->saveOrder($post);
        }
    }
}

?>


