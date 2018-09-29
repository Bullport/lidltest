<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tax7 = $manager->find('App\Entity\SalesTax', 1);
        $tax19 = $manager->find('App\Entity\SalesTax', 2);

        $producer = [];
        $producer['Kerrygold'] = $manager->find('App\Entity\Producer', 1);
        $producer['Milbona'] = $manager->find('App\Entity\Producer', 2);
        $producer['Formil'] = $manager->find('App\Entity\Producer', 3);
        $producer['Perlenbacher'] = $manager->find('App\Entity\Producer', 4);


        $product = new Product();
        $product->setEan('4001954161010');
        $product->setIdentifier('Original irische Butter 250g');
        $product->setDescription('original irische Butter, mildgesäuert, abgepackt in Deutschland');
        $product->setSalesPrice(1.19);
        $product->setTax($tax7);
        $product->setProducer($producer['Kerrygold']);
        $manager->persist($product);

        $product = new Product();
        $product->setEan('20082703');
        $product->setIdentifier('Käsescheiben 500g');
        $product->setDescription('Käsescheiben aus Deutschland');
        $product->setSalesPrice(1.29);
        $product->setTax($tax7);
        $product->setProducer($producer['Milbona']);
        $manager->persist($product);

        $product = new Product();
        $product->setEan('20446185');
        $product->setIdentifier('Colorwaschmittel flüssig 1,5l');
        $product->setDescription('Flüssigwaschmittel für Farbiges');
        $product->setSalesPrice(5.99);
        $product->setTax($tax19);
        $product->setProducer($producer['Formil']);
        $manager->persist($product);

        $product = new Product();
        $product->setEan('42143833');
        $product->setIdentifier('Pils 0,5l');
        $product->setDescription('Pils in der bewährten Plastikflasche, 6er Gebinde');
        $product->setSalesPrice(2.49);
        $product->setTax($tax19);
        $product->setProducer($producer['Perlenbacher']);
        $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SalesTaxFixtures::class,
            ProducerFixtures::class,
        );
    }
}