<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\BranchRepository;

class ProductFixtures extends Fixture
{

    private $branchRepository;

    public function __construct(BranchRepository $branchRepository){
        $this->branchRepository = $branchRepository;   
    }

    public function load(ObjectManager $manager): void
    {
        $branches=  $this->branchRepository->findAll();
        foreach($branches as $branch){
            $product = new Product();
            $product->setName('Calcetines');
            $product->setPrice(3500);
            $product->setBranch($branch);
            $product->setActive(true);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
