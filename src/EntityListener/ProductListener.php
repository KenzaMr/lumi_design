<?php

namespace App\EntityListener;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event:'prePersist',entity:Product::class)]
#[AsEntityListener(event:'preUpdate', entity:Product::class)]
class ProductListener
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->generateSlug($args);
    }
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->generateSlug($args);
    }
    private function generateSlug($args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }
        $entity->setSlug($this->slugger->slug($entity->getName())->lower());
    }
}
