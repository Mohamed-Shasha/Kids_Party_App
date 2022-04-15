<?php

namespace App\DataFixtures;

use App\Factory\PartyFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'username' => 'matt',
            'password' => 'smith',
            'role' => 'ROLE_ADMIN'
        ]);

        UserFactory::createOne([
            'username' => 'john',
            'password' => 'doe',
            'role' => 'ROLE_ADMIN'
        ]);

        PartyFactory::createOne([
            'title' => 'birthday party',
            'description' => 'We have a party room for Princesses, Superheros, Minions and budding Pop Stars', 'priceperhour' => 10,
            'imagePath' => 'https://media.istockphoto.com/photos/happy-childre…ticolored-confetti-on-yellow-picture-id1150333197'


        ]);

        PartyFactory::createOne([
            'title' => 'ball pool',
            'description' => 'Come along and enjoy: play frames with fun slides, ball pools, climbing frames, soccer pitch, disco dancing room
Our wooden jigsaw puzzles and threading games – excellent for refining fine motor skills
Musical instruments'
,
            'priceperhour' => 10,
            'imagePath' => 'https://media.istockphoto.com/photos/children-playing-in-the-ball-pool-picture-id174906383?s=612x612'


        ]);
    }
}
