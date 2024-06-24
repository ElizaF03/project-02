<?php

namespace Request;

class ProductRequest extends Request
{
    public function getProductId(): string
    {
        return $this->data['id-product'];
    }
}