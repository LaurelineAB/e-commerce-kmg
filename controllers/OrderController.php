<?php

class OrderController extends AbstractController {

    public function __construct(){
        
        $this->om = new OrderManager();
        $this->pm = new ProductManager();

    }

    public function createOrder(array $post){
    // Rendu de la vue "orders/create.phtml" avec le tableau $post
    $this->render('orders/create.phtml', $post);

        if(isset($_POST['add'])){
            $this->om->saveOrder($post);
        }
    }
    
    public function OrderByUser(User $user){
        $this->om->getOrderByUser($user);
        $this->render("orders/by-user.phtml", $userOrder);
    }
    
    
}

?>
