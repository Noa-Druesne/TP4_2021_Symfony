<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoversFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");
        for($i=1;$i<=5;$i++){
            $covers = new \App\Entity\Covers();
            $covers->setIsbn("ISBN n°$i")->setCaption("<p>" . join($faker->paragraphs, "</p><p>" . "</p>"))
                ->setDate($faker->dateTime())->setSource("Source n°$i")->setLicence("Licence n°$i")
                ->setFilename("Filename n°$i");
            $manager->persist($covers);
        }
        $manager->flush();
    }
}
