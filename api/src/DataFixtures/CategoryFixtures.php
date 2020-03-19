<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++){
            $category = new Category();
            $category->setName($faker->words(6,true));
            $manager->persist($category);
        }

        $manager->flush();
    }


}
