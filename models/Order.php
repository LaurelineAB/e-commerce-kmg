<?php
class Order {
    private int $id;
    private $date;
    private $product;
    private $user;
    private $price;

    public function __construct(int $id, $date, $product, $user, $price) {
        $this->id = $id;
        $this->date = $date;
        $this->product = $product;
        $this->user = $user;
        $this->price = $price;

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

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product): void {
        $this->product = $product;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user): void {
        $this->user = $user;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price): void {
        $this->price = $price;
    }
}

?>