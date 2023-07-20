<?php

Class OrderController extends AbstractController {

    private OrderManager $O_manager;

    public function __construct(OrderController $O_manager){

        $this->OrderManager = $O_manager;

    }

    public function createOrder(array $post){
    // Rendu de la vue "orders/create.phtml" avec le tableau $post
    $this->render('orders/create.phtml', $post);

    if(isset($_POST['add'])){
        $this->OrderManager->saveOrder($post);
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


