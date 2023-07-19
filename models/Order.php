<?php
class Order {
    private ? int $id;
    private $date;
    private User $userId;
    private Product $productId;
    private float $totalPrice;

    public function __construct($date, $userId, $productId, $totalPrice) {
        $this->id = null;
        $this->date = $date;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->totalPrice = $totalPrice;

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

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId): void {
        $this->productId = $productId;
    }

    public function getTotalPrice() {
        return $this->TotalPrice;
    }

    public function setTotalPrice($totalPrice): void {
        $this->totalPrice = $totalPrice;
    }
}

?>