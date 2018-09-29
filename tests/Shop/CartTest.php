<?php

namespace App\Tests\Shop;

use App\Entity\Product;
use App\Entity\SalesTax;
use App\Shop\Cart;
use App\Shop\CartProduct;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CartTest
 * @package App\Tests\Shop
 * @group shop
 */
class CartTest extends TestCase
{
    /**
     * @var Cart|null
     */
    private $testSubject = null;

    /**
     * @var array
     */
    private $cartProducts = [];

    protected function setUp()
    {
        $this->testSubject = new Cart();
        $this->cartProducts = array();

        parent::setUp();
    }

    private function createCartProducts(): void
    {
        $tax07 = \Mockery::mock(SalesTax::class);
        $tax07->shouldReceive('getPercentage')->andReturn(7.0);
        $tax19 = \Mockery::mock(SalesTax::class);
        $tax19->shouldReceive('getPercentage')->andReturn(19.0);

        $products = [];
        $this->cartProducts = [];

        $products[0] = \Mockery::mock(Product::class);
        $products[0]->shouldReceive('getSalesPrice')->andReturn(0.99);
        $products[0]->shouldReceive('getTax')->andReturn($tax07);
        $products[0]->shouldReceive('getId')->andReturn(1000);
        $this->cartProducts[0] = new CartProduct();
        $this->cartProducts[0]->setProduct($products[0]);
        $this->cartProducts[0]->setAmount(12.0);

        $products[1] = \Mockery::mock(Product::class);
        $products[1]->shouldReceive('getSalesPrice')->andReturn(1.49);
        $products[1]->shouldReceive('getTax')->andReturn($tax07);
        $products[1]->shouldReceive('getId')->andReturn(1250);
        $this->cartProducts[1] = new CartProduct();
        $this->cartProducts[1]->setProduct($products[1]);
        $this->cartProducts[1]->setAmount(7.0);

        $products[2] = \Mockery::mock(Product::class);
        $products[2]->shouldReceive('getSalesPrice')->andReturn(4.99);
        $products[2]->shouldReceive('getTax')->andReturn($tax07);
        $products[2]->shouldReceive('getId')->andReturn(25000);
        $this->cartProducts[2] = new CartProduct();
        $this->cartProducts[2]->setProduct($products[2]);
        $this->cartProducts[2]->setAmount(2.0);

        $products[3] = \Mockery::mock(Product::class);
        $products[3]->shouldReceive('getSalesPrice')->andReturn(9.99);
        $products[3]->shouldReceive('getTax')->andReturn($tax19);
        $products[3]->shouldReceive('getId')->andReturn(375000);
        $this->cartProducts[3] = new CartProduct();
        $this->cartProducts[3]->setProduct($products[3]);
        $this->cartProducts[3]->setAmount(2.0);

        $this->cartProducts[4] = new CartProduct();
        $this->cartProducts[4]->setProduct($products[0]);
        $this->cartProducts[4]->setAmount(5.0);
    }

    public function addProvider()
    {
        $this->createCartProducts();

        return [
            [ //Add a new product that not exists in cart yet
                [$this->cartProducts[0], $this->cartProducts[1]],
                $this->cartProducts[2],
                [$this->cartProducts[0], $this->cartProducts[1], $this->cartProducts[2]],
                [12.0, 7.0, 2.0]
            ],
            [ //Add a product that already exists in cart
                [$this->cartProducts[0], $this->cartProducts[1]],
                $this->cartProducts[4],
                [$this->cartProducts[0], $this->cartProducts[1]],
                [17.0, 7.0]
            ],
            [ //Add a product to an empty cart
                [],
                $this->cartProducts[3],
                [$this->cartProducts[3]],
                [2.0]
            ]
        ];
    }

    public function removeProvider()
    {
        $this->createCartProducts();

        return [
            [ //Remove a product that exists in cart
                [$this->cartProducts[0], $this->cartProducts[1], $this->cartProducts[3]],
                2,
                [$this->cartProducts[0], $this->cartProducts[1]]
            ],
            [ //Try to remove a non existing item causes no error
                [$this->cartProducts[0], $this->cartProducts[1], $this->cartProducts[3]],
                5,
                [$this->cartProducts[0], $this->cartProducts[1], $this->cartProducts[3]]
            ],
        ];
    }

    /**
     * @param array $existingCartItems
     * @param CartProduct $itemToAdd
     * @param array $expectedCartItems
     * @param array $expectedItemAmounts
     *
     * @dataProvider addProvider
     */
    public function testIfCartCanAddItems(
        array $existingCartItems,
        CartProduct $itemToAdd,
        array $expectedCartItems,
        array $expectedItemAmounts
    )
    {
        $this->testSubject->setProducts($existingCartItems);
        $this->testSubject->addProduct($itemToAdd);
        $this->assertEquals($expectedCartItems, $this->testSubject->getProducts());

        foreach($this->testSubject->getProducts() AS $key => $product) {
            $this->assertEquals($expectedItemAmounts[$key], $product->getAmount());
        }

    }

    /**
     * @param array $existingCartItems
     * @param int $itemToRemove
     * @param array $expectedCartItems
     *
     * @dataProvider removeProvider
     */
    public function testIfCartCanRemoveItems(
        array $existingCartItems,
        int $itemToRemove,
        array $expectedCartItems
    )
    {
        $this->testSubject->setProducts($existingCartItems);
        $this->testSubject->removeProduct($itemToRemove);
        $this->assertEquals($expectedCartItems, $this->testSubject->getProducts());
    }

}
