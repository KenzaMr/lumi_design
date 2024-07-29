<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($this->faker));
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $produit = new Product();
            $produit->setName('Produit '.$i);
            $produit->setPrice($this->faker->randomFloat());
            $produit->setDescription($this->faker->paragraph());
            $produit->setStock($this->faker->numberBetween(0,100));
            $produit->setSlug('test');
            $produit->setImage($this->faker->imageUrl(400));
            // $produit->setDateUpdate(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-3 months')));
            $produit->setCategory($this->getReference('CATEGORY' . mt_rand(0, 4)));

            $manager->persist($produit);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            
        ];
    }
}
