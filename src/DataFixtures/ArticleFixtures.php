<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $category = new Category;
            $category
                ->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
            $manager->persist($category);

            for ($j = 1; $j < mt_rand(4, 6); $j++) {
                $article = new Article;
                $article
                    ->setTitle($faker->sentence())
                    ->setContent('<p>' . join('</p><p>', [$faker->paragraphs(5)]) . '</p>')
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);
                $manager->persist($article);

                for ($k = 0; $k < mt_rand(4, 10); $k++) {
                    $now = new DateTime();
                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;

                    $comment = new Comment;
                    $comment
                        ->setArticle($faker->name)
                        ->setContent('<p>' . join('</p><p>', [$faker->paragraphs(2)]) . '</p>')
                        ->setCreatedAt($faker->sateTimeBetween('-' . $days . ' days'))
                        ->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
