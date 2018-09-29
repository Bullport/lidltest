<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProducerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $producer = new Producer();
        $producer->setName('Kerrygold');
        $manager->persist($producer);

        $producer = new Producer();
        $producer->setName('Milbona');
        $manager->persist($producer);

        $producer = new Producer();
        $producer->setName('Formil');
        $manager->persist($producer);

        $producer = new Producer();
        $producer->setName('Perlenbacher');
        $manager->persist($producer);

        $manager->flush();
    }
}