<?php

namespace Entity;

class Order
{
    private int $id;
    private int $userId;
    private string $firstName;
    private string $lastName;
    private string $address;
    private string $phone;
    private string $totalPrice;
    private string $date;

    public function __construct(int $id, int $userId, string $firstName, string $lastName, string $address, string $phone, string $totalPrice, string $date)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->phone = $phone;
        $this->totalPrice = $totalPrice;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}