<?php
namespace Model;

class Order extends Model
{
    public function addInfo( $userId, $firstName,  $lastName, $address,  $phone, $totalPrice,  $date): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO orders (user_id, first_name, last_name, address, phone, total_price, date) VALUES(:user_id, :first_name, :last_name, :address, :phone, :total_price, :date)');
        $stmt->execute(array('user_id'=>$userId, 'first_name' => $firstName, 'last_name' => $lastName, 'address' => $address, 'phone' => $phone, 'total_price' => $totalPrice, 'date' => $date));
    }
    public function getOrder($userId):array{
        $stmt = $this->getPdo()->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $stmt->execute(array('user_id'=>$userId));
        return $stmt->fetch();
    }
}