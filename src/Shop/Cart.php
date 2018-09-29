<?php

namespace App\Shop;

use App\Shop\CartProduct;

class Cart
{
    private $id;

    private $products;

    public function __construct()
    {
        $this->id = uniqid('shop-', true);
        $this->products = array();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id | UUID
     * @return Cart
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getProducts(): ?array
    {
        return $this->products;
    }

    /**
     * @param array $products
     * @return Cart
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @param CartProduct $cartProduct
     * @return Cart
     */
    public function addProduct(CartProduct $cartProduct): self
    {
        foreach($this->products as $key => $existingCartProduct) {
            if ($existingCartProduct->getProduct()->getId() == $cartProduct->getProduct()->getId()) {
                $this->products[$key]->setAmount(
                    $existingCartProduct->getAmount() + $cartProduct->getAmount()
                );

                return $this;
            }
        }

        $this->products[] = $cartProduct;

        return $this;

    }

    /**
     * @param int $arrayKeyId
     * @return Cart
     */
    public function removeProduct(int $arrayKeyId): self
    {
        if (array_key_exists($arrayKeyId, $this->products)) {
            unset($this->products[$arrayKeyId]);
        }

        return $this;
    }

}