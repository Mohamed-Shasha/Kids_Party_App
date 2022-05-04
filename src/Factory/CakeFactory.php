<?php

namespace App\Factory;

use App\Entity\Cake;
use App\Repository\CakeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Cake>
 *
 * @method static Cake|Proxy createOne(array $attributes = [])
 * @method static Cake[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Cake|Proxy find(object|array|mixed $criteria)
 * @method static Cake|Proxy findOrCreate(array $attributes)
 * @method static Cake|Proxy first(string $sortedField = 'id')
 * @method static Cake|Proxy last(string $sortedField = 'id')
 * @method static Cake|Proxy random(array $attributes = [])
 * @method static Cake|Proxy randomOrCreate(array $attributes = [])
 * @method static Cake[]|Proxy[] all()
 * @method static Cake[]|Proxy[] findBy(array $attributes)
 * @method static Cake[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Cake[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CakeRepository|RepositoryProxy repository()
 * @method Cake|Proxy create(array|callable $attributes = [])
 */
final class CakeFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'imagePath' => self::faker()->text(),
            'price' => self::faker()->randomFloat(),
            'description' => self::faker()->text(),
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Cake $cake): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Cake::class;
    }
}
