<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE_1 = 'user1';
    public const USER_REFERENCE_2 = 'user2';
    public const USER_REFERENCE_3 = 'user3';

    public function load(ObjectManager $manager)
    {
        // User 1
        $user1 = new User();
        $user1->setName("Islam");
        $user1->setEmail("islam.askar@gmail.com");
        $manager->persist($user1);
        $this->addReference(self::USER_REFERENCE_1, $user1);

        // User 2
        $user2 = new User();
        $user2->setName("Islam Askar");
        $user2->setEmail("islam.askar@comprando.io");
        $manager->persist($user2);
        $this->addReference(self::USER_REFERENCE_2, $user2);

        //User 3
        $user3 = new User();
        $user3->setName("Islam Salah Askar");
        $user3->setEmail("islam@askar.site");
        $manager->persist($user3);
        $this->addReference(self::USER_REFERENCE_3, $user3);

        $manager->flush();
    }
}
