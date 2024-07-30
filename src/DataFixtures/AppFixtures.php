<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        CategoryFactory::createMany(5);
        ProductFactory::createMany(10, function () {
            return [
                'category' => CategoryFactory::random(),
                // Ceci va assigner une catégorie aléatoire existante à un produit
            ];
        });
    }
}
