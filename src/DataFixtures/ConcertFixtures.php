<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    
    public const TOUR_REFERENCE = 'concert';
    public const DATE = ['2022-12-12','2023-12-01','2022-02-14','2022-03-27','2022-12-12', '2012-12-12', '2017-05-27', '1999-01-01', '1855-11-30', '2000-09-03', '1990-05-05', '1970-01-01'];
    public const LENGTH = 8;

    public function load(ObjectManager $manager): void {
        foreach (self::DATE as $key => $date) {
            $date = new DateTime($date);
            $band = $this->getReference(BandFixtures::GROUP_REFERENCE.'_'.random_int(0,BandFixtures::LENGTH-1));
            
            // Creation de l'instance
            $concert = (new Concert())
            ->setDate($date)
            ->setBand($band);

            // Enregistrement Fixture
            $manager->persist($concert);
            $this->addReference(self::TOUR_REFERENCE.'_'.$key, $concert);
        }

        // Enregistrement
        $manager->flush();

    }

    public function getDependencies() {
        return [
            BandFixtures::class
        ];
    }
}
