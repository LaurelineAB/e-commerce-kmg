<?php
class Order {
    private ? int $id;
    private $date;
    private User $userId;
    private float $totalPrice;
    private $products = [];

    public function __construct($date, $userId, $totalPrice) {
        $this->id = null;
        $this->date = $date;
        $this->userId = $userId;
        $this->totalPrice = $totalPrice;
        $this->products = [];

    }

    // Getters and setters

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId): void {
        $this->userId = $userId;
    }

    public function getTotalPrice() {
        return $this->TotalPrice;
    }

    public function setTotalPrice($totalPrice): void {
        $this->totalPrice = $totalPrice;
    }

    public function getProducts(){
        return $this->products;
    }
    public function setProducts($products){
        $this->products = $products;
    }

}

?>