<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingsRepository::class)]
class Bookings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'time')]
    private $beginAt;

    #[Assert\GreaterThan(5)]
    #[ORM\Column(type: 'integer')]
    private $numberOfKids;

    #[ORM\ManyToOne(targetEntity: Party::class, inversedBy: 'bookings')]
    private $title;

    #[ORM\Column(type: 'time')]
    private $endAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookings')]
    private $user;

    #[ORM\Column(type: 'float')]
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getNumberOfKids(): ?int
    {
        return $this->numberOfKids;
    }

    public function setNumberOfKids(int $numberOfKids): self
    {
        $this->numberOfKids = $numberOfKids;

        return $this;
    }

    public function getTitle(): ?party
    {
        return $this->title;
    }

    public function setTitle(?party $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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


//    /**
//     *
//     * Callback called each time we create a reservation
//     *
//     * @ORM\PrePersist
//     * @ORM\PrePersist
//     * @ORM\PreUpdate
//     */
//    public function prePersist()
//    {
//
//        if (empty($this->amount)) {
//            $this->amount = $this->title->getPriceperhour() * $this->getDuration();
//        }
//    }

    public function getDuration()
    {
        $diff = ($this->endAt)->diff($this->beginAt);
        return $diff->h + ($diff->i) / 60;


    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
