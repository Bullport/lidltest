<?php

namespace App\Shop;

use App\Shop\Cart;

class CartCalculator
{
    private $totalGross = 0.0;
    private $totalTax = 0.0;
    private $totalNet = 0.0;
    private $cart = null;

    /**
     * @return Cart|null
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     * @return CartCalculator
     */
    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
        $this->calculateCart(); //(Re-)Calculate cart only once a new cart is injected

        return $this;
    }

    /**
     * @return float
     */
    public function getCartTotalGross(): ?float
    {
        return $this->totalGross;
    }

    /**
     * @return float
     */
    public function getCartTotalTax(): ?float
    {
        return $this->totalTax;
    }

    /**
     * @return float
     */
    public function getCartTotalNet(): ?float
    {
        return $this->totalNet;
    }

    /**
     * Calculates gross, net and tax amount of given cart
     * @return void
     */
    private function calculateCart()
    {
        $this->totalGross = 0.0;
        $this->totalTax = 0.0;
        $this->totalNet = 0.0;

        foreach($this->cart->getProducts() as $cartProduct)
        {
            $product = $cartProduct->getProduct();
            $productPrice = $cartProduct->getAmount() * $product->getSalesPrice();

            $this->totalGross += $productPrice;

            $taxValue = $product->getTax()->getPercentage();
            $taxAmount = round($productPrice / (100 + $taxValue) * $taxValue, 4, PHP_ROUND_HALF_UP);
            $this->totalTax += $taxAmount;

            $this->totalNet += ($productPrice - $taxAmount);
        }
    }
}