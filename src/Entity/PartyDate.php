<?php

namespace App\Entity;

use App\Repository\PartyDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartyDateRepository::class)]
class PartyDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $party_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartyId(): ?int
    {
        return $this->party_id;
    }

    public function setPartyId(int $party_id): self
    {
        $this->party_id = $party_id;

        return $this;
    }
}
