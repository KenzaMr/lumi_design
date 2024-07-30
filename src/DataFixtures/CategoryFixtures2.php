<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures2 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName('categorie' . $i);
            $manager->persist($category);
            $this->addReference('CATEGORY' . $i, $category);
        }



        $manager->flush();
    }
}
