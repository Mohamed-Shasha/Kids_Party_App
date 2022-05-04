<?php

namespace App\Tests;

use App\Repository\CakeRepository;
use App\Repository\PartyRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminCanCreatePartyTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->catchExceptions(true);

        // Arrange - get repository references
        $partyRepo = static::getContainer()->get(PartyRepository::class);
        $userRepository = static::getContainer()->get(UserRepository::class);


        $user = 'admin';
        $adminUser = $userRepository->findOneBy(['username' => $user]);


        // Arrange - request parameters
        $httpMethod = ['GET','POST'];
        $url = '/party/new';


        $parties = $partyRepo->findAll();
        $numberOfPartiesBeforeOneCreated = count($parties);
        $expectedNumberOfPartyAfterOneCreated = $numberOfPartiesBeforeOneCreated + 1;


        $client->loginUser($adminUser);


        $submitButtonName = 'Save';
        $client->submit($client->request((string)$httpMethod, $url)->selectButton($submitButtonName)->form([
            'party[title]' => 'pool party',
            'party[description]' => 'NEW party Test',
            'party[priceperhour]' => 20,

        ]));

        // Act - get array of Cakes AFTER adding
        $parties = $partyRepo->findAll();


        // Assert
        $this->assertCount($expectedNumberOfPartyAfterOneCreated, $parties);

    }
}
