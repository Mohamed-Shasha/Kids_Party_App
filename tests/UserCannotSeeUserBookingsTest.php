<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserCannotSeeUserBookingsTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->catchExceptions(true);
        $user = 'Mohamed';
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username'=>$user]);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/bookings');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertSame(Response::HTTP_FORBIDDEN, $statusCode);

    }
}
