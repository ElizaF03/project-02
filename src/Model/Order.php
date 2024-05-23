<?php

namespace Model;

class Order extends Model
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

    public static function addInfo(int $userId, string $firstName, string $lastName, string $address, string $phone, float $totalPrice, string $date): void
    {
        $stmt = self::getPdo()->prepare('INSERT INTO orders (user_id, first_name, last_name, address, phone, total_price, date) VALUES(:user_id, :first_name, :last_name, :address, :phone, :total_price, :date)');
        $stmt->execute(array('user_id' => $userId, 'first_name' => $firstName, 'last_name' => $lastName, 'address' => $address, 'phone' => $phone, 'total_price' => $totalPrice, 'date' => $date));
    }

    public static function getOrder($userId): ?Order
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $stmt->execute(array('user_id' => $userId));
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $obj = new self($result['id'], $userId, $result['first_name'], $result['last_name'], $result['address'], $result['phone'], $result['total_price'], $result['date']);
        return $obj;
    }
}