<?php

namespace App\Shop;

use App\Entity\Product;

class CartProduct
{
    private $product;

    private $amount;

    /**
     * @return Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return CartProduct
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return CartProduct
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

}