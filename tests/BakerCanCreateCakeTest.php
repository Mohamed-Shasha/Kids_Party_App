<?php

namespace App\Tests;


use App\Repository\CakeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
class BakerCanCreateCakeTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->catchExceptions(true);

        // Arrange - get repository references
        $cakeRepo = static::getContainer()->get(CakeRepository::class);
        $userRepository = static::getContainer()->get(UserRepository::class);



        $user = 'shasha';
        $bakerUser = $userRepository->findOneBy(['username'=>$user]);



        // Arrange - request parameters
        $httpMethod = 'GET';
        $url = '/cake/new';


        $cakes = $cakeRepo->findAll();
        $numberOfCakesBeforeOneCreated = count($cakes);
        $expectedNumberOfCakesAfterOneCreated = $numberOfCakesBeforeOneCreated + 1;


        $client->loginUser($bakerUser);



        $submitButtonName = 'Save';
        $client->submit($client->request($httpMethod, $url)->selectButton($submitButtonName)->form([
            'cake[name]'=>'NEW TEST Chocolate Buttercream',
            'cake[description]'=>'NEW Chocolate sponge cake with a layer of chocolate buttercream filling',
            'cake[price]'=>20,
            'cake[imagePath]'=>'https://thenaturalbakery.ie/wp-content/uploads/2021/12/IMG_8606.jpg',
        ]));

        // Act - get array of Cakes AFTER adding
        $cakes =$cakeRepo->findAll();


        // Assert
        $this->assertCount($expectedNumberOfCakesAfterOneCreated, $cakes);
    }
}
