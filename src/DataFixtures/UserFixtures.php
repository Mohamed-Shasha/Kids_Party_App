<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        UserFactory::createOne([
            'username' => 'Admin',
            'password' => 'pass',
            'role' => 'ROLE_ADMIN'
        ]);

        UserFactory::createOne([
            'username' => 'Mohamed',
            'password' => 'pass',
            'role' => 'ROLE_USER'
        ]);
        UserFactory::createOne([
            'username' => 'Shasha',
            'password' => 'pass',
            'role' => 'ROLE_BAKER'
        ]);


    }
}
