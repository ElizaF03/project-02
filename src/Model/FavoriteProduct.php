<?php

namespace Model;
class FavoriteProduct extends Model


{
    private int $id;
    private int $userId;
    private Product $product;


    public function __construct(int $id,int $userId, Product $product)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public static function getOne(int $userId, int $productId): ?FavoriteProduct
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $result = $stmt->fetch();
        $product =  Product::getById($result['product_id']);
        $obj = new self($result["id"], $result['user_id'], $product);
        return $obj;
    }

    public static function getAllByUserId(int $userId): array
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE user_id =:user_id');
        $stmt->execute(['user_id' => $userId]);
        $favoriteProducts = $stmt->fetchAll();
        foreach ($favoriteProducts as $favoriteProduct) {
            $product =  Product::getById($favoriteProduct['product_id']);
            $result[$favoriteProduct['id']] = new self ($favoriteProduct["id"], $favoriteProduct['user_id'], $product);
        }
        return $result;
    }

    public static function create(int $userId, int $productId): void
    {
        $stmt = self::getPdo()->prepare('INSERT INTO favorite_user_products (user_id, product_id) VALUES(:user_id, :product_id)');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
    }

    public static function remove(int $userId, int $productId): void
    {
        $stmt = self::getPdo()->prepare("DELETE FROM favorite_user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
    }
}