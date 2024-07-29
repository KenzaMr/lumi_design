<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use \Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $produit = new Product();
            $produit->setName('Test');
            $produit->setPrice($faker->randomFloat());
            $produit->setDescription($faker->paragraph());
            $produit->setImage('test');
            $produit->setStock($faker->randomDigitNotNull());
            $produit->setSlug('test');
            $produit->setCategory($this->getReference('category'));

            $manager->persist($produit);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
