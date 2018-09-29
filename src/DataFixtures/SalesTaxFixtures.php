<?php

namespace App\DataFixtures;

use App\Entity\SalesTax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SalesTaxFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tax7 = new SalesTax();
        $tax7->setPercentage(7.0);
        $manager->persist($tax7);

        $tax19 = new SalesTax();
        $tax19->setPercentage(19.0);
        $manager->persist($tax19);

        $manager->flush();
    }
}