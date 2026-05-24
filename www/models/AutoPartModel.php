<?php

class AutoPartModel
{
    // Уникальный идентификатор запчасти
    public int $id;

    // Название запчасти
    public string $name;

    // Категория транспорта (Машина, Мотоцикл и т.д.)
    public string $category;

    // Тип запчасти (Двигатель, Резина, Карбюратор)
    public string $partType;

    // Цена
    public float $price;

    // Количество на складе
    public int $count;

    // Производитель
    public string $producer;

    // Гарантия
    public string $warranty;

    // Описание
    public string $description;

    // Путь к изображению
    public string $image;

    // Срок доставки
    public string $deliveryTime;

    public function __construct(
        int $id,
        string $name,
        string $category,
        string $partType,
        float $price,
        int $count,
        string $producer,
        string $warranty,
        string $description,
        string $image,
        string $deliveryTime
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->partType = $partType;
        $this->price = $price;
        $this->count = $count;
        $this->producer = $producer;
        $this->warranty = $warranty;
        $this->description = $description;
        $this->image = $image;
        $this->deliveryTime = $deliveryTime;
    }
}