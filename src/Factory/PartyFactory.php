<?php

namespace App\Factory;

use App\Entity\Party;
use App\Repository\PartyRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Party>
 *
 * @method static Party|Proxy createOne(array $attributes = [])
 * @method static Party[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Party|Proxy find(object|array|mixed $criteria)
 * @method static Party|Proxy findOrCreate(array $attributes)
 * @method static Party|Proxy first(string $sortedField = 'id')
 * @method static Party|Proxy last(string $sortedField = 'id')
 * @method static Party|Proxy random(array $attributes = [])
 * @method static Party|Proxy randomOrCreate(array $attributes = [])
 * @method static Party[]|Proxy[] all()
 * @method static Party[]|Proxy[] findBy(array $attributes)
 * @method static Party[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Party[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PartyRepository|RepositoryProxy repository()
 * @method Party|Proxy create(array|callable $attributes = [])
 */
final class PartyFactory extends ModelFactory
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
            'title' => self::faker()->text(),
            'description' => self::faker()->text(),
            'priceperhour' => self::faker()->randomNumber(),
            'imagePath' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Party $party): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Party::class;
    }
}
