<?php

namespace Model;
class FavoriteProduct extends Model


{
    private int $id;
    private int $productId;
    private int $userId;
    private string $name;
    private float $price;
    private string $img_url;

    public function __construct(int $id, int $productId, int $userId, string $name, float $price, string $img_url)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->userId = $userId;
        $this->name = $name;
        $this->price = $price;
        $this->img_url = $img_url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getName(): string{
        return $this->name;
    }
    public function getPrice(): float{
        return $this->price;
    }
    public function getImgUrl(): string{
        return $this->img_url;
    }

    public static function getOne(int $userId, int $productId): ?FavoriteProduct
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $result = $stmt->fetch();

        $obj = new self($result["id"], $result['user_id'], $result['product_id'], $result['name'], $result['price'], $result['img_url']);
        return $obj;
    }

    public static function getAllByUserId(int $userId): array
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE user_id =:user_id');
        $stmt->execute(['user_id' => $userId]);
        $favoriteProducts = $stmt->fetchAll();
        foreach ($favoriteProducts as $favoriteProduct) {
            $result[$favoriteProduct['id']] = new self ($favoriteProduct["id"], $favoriteProduct['user_id'], $favoriteProduct['product_id'],$favoriteProduct['name'], $favoriteProduct['price'], $favoriteProduct['img_url']);
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