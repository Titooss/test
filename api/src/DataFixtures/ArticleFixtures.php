<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\DataFixtures\CategoryFixtures;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $categoriesRepo = $manager->getRepository(Category::class);
        $categoriesArray = [];

        foreach ($categoriesRepo->findAll() as $category){
            $categoriesArray[] = $category->getId();

        }

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++){
            $article = new Article();
            $article->setTitle($faker->words(3,true))
                ->setBody($faker->text(1000));

            $key = array_rand($categoriesArray,1);
            $id = $categoriesArray[$key];
            $category = $categoriesRepo->find($id);
            $article->setCategory($category);

            $manager->persist($article);
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
