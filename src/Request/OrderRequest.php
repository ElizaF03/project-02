<?php

namespace Request;

class OrderRequest extends Request
{
    public function getFirstName(): string
    {
        return $this->data['first-name'];
    }
    public function getLastName(): string
    {
        return $this->data['last-name'];
    }
    public function getAddress(): string
    {
        return $this->data['address'];
    }
    public function getPhone(): string
    {
        return $this->data['phone'];
    }
    public function getTotalPrice(): string
    {
        return $this->data['total-price'];
    }
    public function validate(): array
    {
        $errors = [];
        if (strlen($this->getFirstName()) < 2) {
            $errors['first-name'] = 'Name is too short';
        }

        if (strlen($this->getLastName()) < 2) {
            $errors['last-name'] = 'Last name is too short';
        }

        if (strlen($this->getAddress()) < 2) {
            $errors['address'] = 'Address is too short';
        }
        if (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $this->getPhone())) {
            $errors['phone'] = 'Phone number is invalid';
        }
        if ((integer)$this->getTotalPrice() === 0) {
            $errors['total-price'] = 'Empty order';
        }
        return $errors;
    }

}