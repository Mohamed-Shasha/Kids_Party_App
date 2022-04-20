<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TradeRepository::class)]
class Trade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'time')]
    private $yu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYu(): ?\DateTimeInterface
    {
        return $this->yu;
    }

    public function setYu(\DateTimeInterface $yu): self
    {
        $this->yu = $yu;

        return $this;
    }
}
