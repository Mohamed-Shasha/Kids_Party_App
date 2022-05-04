<?php

namespace App\Entity;

use App\Repository\CakeDeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CakeDeliveryRepository::class)]
class CakeDelivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'address')]
    private $name;

    #[ORM\OneToOne(targetEntity: Order::class, cascade: ['persist', 'remove'])]
    private $cadeorder;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'delivery')]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'time')]
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?User
    {
        return $this->name;
    }

    public function setName(?User $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCadeorder(): ?order
    {
        return $this->cadeorder;
    }

    public function setCadeorder(?order $cadeorder): self
    {
        $this->cadeorder = $cadeorder;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
