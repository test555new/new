<?php

class Order
{
    public int $id;
    public int $accountId;
    public array $items;
    public string $paymentMethod;
    public string $deliveryMethod;
    public string $orderDate;
    public string $deliveryDate;
    public float $totalPrice;
    public string $status;

    public function __construct(
        int $id,
        int $accountId,
        array $items,
        string $paymentMethod,
        string $deliveryMethod,
        string $orderDate,
        string $deliveryDate,
        float $totalPrice,
        string $status = 'new'
    ) {
        $this->id = $id;
        $this->accountId = $accountId;
        $this->items = $items;
        $this->paymentMethod = $paymentMethod;
        $this->deliveryMethod = $deliveryMethod;
        $this->orderDate = $orderDate;
        $this->deliveryDate = $deliveryDate;
        $this->totalPrice = $totalPrice;
        $this->status = $status;
    }
}