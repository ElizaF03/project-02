<?php

namespace Model;
class UserProduct extends Model
{

private int $id;
private User $user;

private Product $product;
private int $quantity;
public function __construct(int $id, User $user, Product $product, int $quantity)
{
    $this->id = $id;
    $this->user = $user;
    $this->product = $product;
    $this->quantity = $quantity;
}
public function getId():int {
    return $this->id;
}
public function getUser():User{
    return $this->user;
}
public function getProduct():Product{
    return $this->product;
}
public function getQuantity():int{
    return $this->quantity;
}

    /**
     * @param int $userId
     * @return UserProduct[]
     */
    public static function getAllByUserId(int $userId): array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts= $stmt->fetchAll();
        if (empty($userProducts)) {
            return [];
        }
        foreach ($userProducts as $userProduct) {
            $user=User::getById($userProduct["user_id"]);
            $product=Product::getById($userProduct["product_id"]);
            $result[$userProduct['id']] = self::hydrate($userProduct, $user, $product);
        }
        return $result;
    }

    public static function getOne(int $userId, int $productId): ?UserProduct
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $user=User::getById($result["user_id"]);
        if($user===null){
            return null;
        }
        $product=Product::getById($result["product_id"]);
        if($product===null){
            return null;
        }
        return self::hydrate($result, $user, $product);
    }
    private static function hydrate(array $data, User $user, Product $product): UserProduct
    {
        $obj = new self($data["id"], $user, $product, $data["quantity"]);
        return $obj;
    }
    public static function create(int $userId, int $productId, int $quantity = 1): void
    {
        $stmt = self::getPdo()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function remove(int $userId, int $productId): void
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public static function removeAll(int $userId): void
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    public static function plusQuantity(int $userId, int $productId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products SET quantity = quantity+1  WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }

    public static function minusQuantity(int $userId, int $productId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products SET quantity = quantity-1  WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }
}