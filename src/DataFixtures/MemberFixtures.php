<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture {

    public const MEMBER_REFERENCE = 'member';
    public const FIRSTNAME = ['Michel', 'Jacky', 'David', 'Gregory', 'Pierre', 'Patrick', 'Jean', 'Pascal', 'Jacqueline', 'Martine', 'Yvette'];
    public const NAME = ['Dupont-Voyant', 'Duclair', 'Popoche', 'Vizion', 'Carton', 'Du Vivier', 'Cartouchard', 'Clowner', 'Castafiole', 'Marmitte', 'Casserole'];
    public const LENGTH = 11*11;

    public function load(ObjectManager $manager): void {
        foreach (self::FIRSTNAME as $key => $firstname) {
            foreach (self::NAME as $key2 => $name) {
                // Creation de l'instance
                $member = (new Member())
                ->setFirstname($firstname)
                ->setLastName($name);

                // Enregistrement Fixture
                $manager->persist($member);
                $this->addReference(self::MEMBER_REFERENCE.'_'.$key*sizeof(self::NAME)+$key2, $member);
            }
        }

        // Enregistrement
        $manager->flush();
    }
}
