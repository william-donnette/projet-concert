<?php

namespace App\DataFixtures;

use App\Entity\Band;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BandFixtures extends Fixture implements DependentFixtureInterface {

    public const GROUP_REFERENCE = 'band';
    public const NAME = ['Les Eclaireurs', 'Les 4 Corbeaux Vertébrés', 'Guitar Hero', 'Magic Sound', 'La Cuisine en Chanson', 'CATABOUM', 'Les Tontons du Son', 'Décroch\'Watt'];
    public const IMG = ['audience', 'batterie', 'concert', 'foule', 'live', 'orchestre', 'rue', 'secte'];
    public const DATE = ['2022-12-12', '2012-12-12', '2017-05-27', '1999-01-01', '1855-11-30', '2000-09-03', '1990-05-05', '1970-01-01'];
    public const LENGTH = 8;

    public function load(ObjectManager $manager): void {
        foreach (self::NAME as $key => $name) {
            // Choix aleatoire
            $created_at = new DateTime(self::DATE[random_int(0, sizeof(self::DATE) - 1)]);

            // Creation de l'instance
            $picture = $this->getReference(PictureFixtures::PICTURE_REFERENCE.'_'.self::IMG[$key]);
            $band = (new Band())
            ->setName($name)
            ->setCreatedAt($created_at)
            ->setPicture($picture);
            $members_number = random_int(1, 4);
            for ($j = 0; $j < $members_number; $j++) {
                $member = $this->getReference(MemberFixtures::MEMBER_REFERENCE.'_'.random_int(0,MemberFixtures::LENGTH-1));
                if (is_null($member->getBand()))
                    $band->addMember($member);
            }
            
            // Enregistrement Fixture
            $manager->persist($band);
            $this->addReference(self::GROUP_REFERENCE.'_'.$key, $band);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            PictureFixtures::class,
            MemberFixtures::class,
        ];
    }
}
