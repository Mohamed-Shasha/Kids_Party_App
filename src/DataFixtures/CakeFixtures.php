<?php

namespace App\DataFixtures;

use App\Entity\Cake;
use App\Factory\CakeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CakeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        CakeFactory::createOne(
           [
               'name'=>'Chocolate Buttercream',
               'description'=>'Chocolate sponge cake with a layer of chocolate buttercream filling',
               'price'=>20,
              'imagePath'=>'https://thenaturalbakery.ie/wp-content/uploads/2021/12/IMG_8606.jpg'

           ]
        );
        CakeFactory::createOne(
            [
                'name'=>'Vanilla Buttercream',
                'description'=>'This is our plain sponge cake layer it with Raspberry Jam and vanilla buttercream. It is finished with white chocolate curls.',
                'price'=>15,
                'imagePath'=>'https://thenaturalbakery.ie/wp-content/uploads/2021/12/IMG_8571-300x300.jpg'

            ]
        );
        CakeFactory::createOne(
            [
                'name'=>'Birthday Cake',
                'description'=>'Classic layers of white sponge, filled with fresh cream and strawberry jam',
                'price'=>18,
                'imagePath'=>'https://thenaturalbakery.ie/wp-content/uploads/2022/01/IMG_0231-300x300.jpg'

            ]
        );
    }
}
