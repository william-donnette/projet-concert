<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture
{
    public const PICTURE_REFERENCE = 'picture';
    public const IMG = ['audience', 'batterie', 'concert', 'foule', 'live', 'orchestre', 'rue', 'secte'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::IMG as $key => $name) {
            // Creation de l'instance
            $picture = (new Picture())
            ->setAlternativeName($name)
            ->setName($name.'.jpg')
            ->setPath('img/'.$name.'.jpg');

            // Enregistrement Fixture
            $manager->persist($picture);
            $this->addReference(self::PICTURE_REFERENCE.'_'.$name, $picture);
        }
        $manager->flush();
    }
}
