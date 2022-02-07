<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Scene;

class SceneFixtures extends Fixture implements DependentFixtureInterface
{
    
    public const SCENE_REFERENCE = 'scene';
    public const SALLE = ['Zenith', 'Grand Palais', 'Kindarena', 'Stade de France', 'Chez Gilbert', 'Zenith Sud', 'Zenith Ouest', 'Zenith Nord', 'Zenith Est'];
    public const LENGTH = 9;

    public function load(ObjectManager $manager): void {
        foreach (self::SALLE as $key => $salle) {
            $concert = $this->getReference(ConcertFixtures::TOUR_REFERENCE.'_'.random_int(0,ConcertFixtures::LENGTH-1));

            // Creation de l'instance
            $scene = (new Scene())
            ->setAdress($salle)
            ->addConcert($concert);

            // Enregistrement Fixture
            $manager->persist($scene);
            $this->addReference(self::SCENE_REFERENCE.'_'.$key, $scene);
        }

        // Enregistrement
        $manager->flush();

    }

    public function getDependencies() {
        return [
            ConcertFixtures::class
        ];
    }
}