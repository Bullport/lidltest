<?php

namespace App\Tests\Shop;

use App\Entity\Product;
use App\Entity\SalesTax;
use App\Shop\Cart;
use App\Shop\CartCalculator;
use App\Shop\CartProduct;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CartCalculatorTest
 * @package App\Tests\Shop
 * @group shop
 */
class CartCalculatorTest extends TestCase
{
    private $testSubject = null;


    protected function setUp()
    {
        $this->testSubject = new CartCalculator();

        parent::setUp();

    }

    /**
     * @return array
     */
    public function cartProvider()
    {
        $tax07 = \Mockery::mock(SalesTax::class);
        $tax07->shouldReceive('getPercentage')->andReturn(7.0);
        $tax19 = \Mockery::mock(SalesTax::class);
        $tax19->shouldReceive('getPercentage')->andReturn(19.0);

        $products = [];
        $cartProducts = [];

        $products[0] = \Mockery::mock(Product::class);
        $products[0]->shouldReceive('getSalesPrice')->andReturn(0.99);
        $products[0]->shouldReceive('getTax')->andReturn($tax07);
        $cartProducts[0] = \Mockery::mock(CartProduct::class);
        $cartProducts[0]->shouldReceive('getProduct')->andReturn($products[0]);
        $cartProducts[0]->shouldReceive('getAmount')->andReturn(12.0);

        $products[1] = \Mockery::mock(Product::class);
        $products[1]->shouldReceive('getSalesPrice')->andReturn(1.49);
        $products[1]->shouldReceive('getTax')->andReturn($tax07);
        $cartProducts[1] = \Mockery::mock(CartProduct::class);
        $cartProducts[1]->shouldReceive('getProduct')->andReturn($products[1]);
        $cartProducts[1]->shouldReceive('getAmount')->andReturn(2.0);

        $products[2] = \Mockery::mock(Product::class);
        $products[2]->shouldReceive('getSalesPrice')->andReturn(4.99);
        $products[2]->shouldReceive('getTax')->andReturn($tax07);
        $cartProducts[2] = \Mockery::mock(CartProduct::class);
        $cartProducts[2]->shouldReceive('getProduct')->andReturn($products[2]);
        $cartProducts[2]->shouldReceive('getAmount')->andReturn(3.0);

        $products[3] = \Mockery::mock(Product::class);
        $products[3]->shouldReceive('getSalesPrice')->andReturn(9.99);
        $products[3]->shouldReceive('getTax')->andReturn($tax19);
        $cartProducts[3] = \Mockery::mock(CartProduct::class);
        $cartProducts[3]->shouldReceive('getProduct')->andReturn($products[3]);
        $cartProducts[3]->shouldReceive('getAmount')->andReturn(2.0);

        $products[4] = \Mockery::mock(Product::class);
        $products[4]->shouldReceive('getSalesPrice')->andReturn(99.00);
        $products[4]->shouldReceive('getTax')->andReturn($tax19);
        $cartProducts[4] = \Mockery::mock(CartProduct::class);
        $cartProducts[4]->shouldReceive('getProduct')->andReturn($products[4]);
        $cartProducts[4]->shouldReceive('getAmount')->andReturn(1.0);


        $carts = array();

        $carts[0] = new Cart(); //Quite normal cart
        $carts[0]->setProducts([$cartProducts[0], $cartProducts[1], $cartProducts[2], $cartProducts[3]]);

        $carts[1] = new Cart(); //Only 1 item
        $carts[1]->setProducts([$cartProducts[4]]);

        $carts[2] = new Cart(); //empty cart

        return [
            [$carts[0], 49.81, 5.1416, 44.6684],
            [$carts[1], 99.00, 15.8067, 83.1933],
            [$carts[2], 0.0, 0.0, 0.0],
        ];
    }

    /**
     * @dataProvider cartProvider
     */
    public function testIfCartCalculationIsCorrect(
        ?Cart $cart,
        float $expectedGrossValue,
        float $expectedTaxValue,
        float $expectedNetValue
    )
    {
        $this->testSubject->setCart($cart);
        $this->assertEquals($expectedGrossValue, $this->testSubject->getCartTotalGross());
        $this->assertEquals($expectedTaxValue, $this->testSubject->getCartTotalTax());
        $this->assertEquals($expectedNetValue, $this->testSubject->getCartTotalNet());
    }

}
