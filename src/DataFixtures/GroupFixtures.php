<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Group;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // Group 1
        $group1 = new Group;
        $group1->setName("Group 1");

        // Add some users
        $group1->addUser($this->getReference(UserFixtures::USER_REFERENCE_1));
        $group1->addUser($this->getReference(UserFixtures::USER_REFERENCE_2));
        $group1->addUser($this->getReference(UserFixtures::USER_REFERENCE_3));

        $manager->persist($group1);

        // Group 2
        $group2 = new Group;
        $group2->setName("Group 2");

        $group2->addUser($this->getReference(UserFixtures::USER_REFERENCE_1));
        $group2->addUser($this->getReference(UserFixtures::USER_REFERENCE_2));

        $manager->persist($group2);

        // Group 3
        $group3 = new Group;
        $group3->setName("Group 3");

        $manager->persist($group3);


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
