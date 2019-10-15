<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("FR-fr");
        for ($i=0; $i < 20; $i++)
        {
            $libelle = $faker->sentence();
            $image = $faker->imageUrl(400, 200);
            $description = $faker->paragraph(2);
            $prix = mt_rand(40, 200);
            $article = new Article();
            $article->setLibelle($libelle)
                    ->setPrix($prix)
                    ->setDescription($description)
                    ->setImage($image);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
