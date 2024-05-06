<?php

class UserProductController extends Model
{
    public function getUserProducts($userId, $className): ?array
    {
        $userProduct = new $className();
        $product = new Product();
        $userProducts = $userProduct->getAllByUserId($userId);
        $productIds = [];
        $products = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = $product->getById($productId);
        }
        if(isset($userProduct['quantity']) ){
        foreach ($products as &$product) {
            foreach ($userProducts as $userProduct) {
                    if ($product['id'] === $userProduct['product_id']) {
                        $product['quantity'] = $userProduct['quantity'];
                    }
                }
            }
        }
        unset($product);
        return $products;
    }
}