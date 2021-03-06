<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $role = 'ROLE_USER';



    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Bookings::class)]
    private $bookings;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Order::class)]
    private $orderCake;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CakeDelivery::class)]
    private $delivery;


    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->orderCake = new ArrayCollection();
        $this->delivery = new ArrayCollection();


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [
            $this->role
        ];
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    /**
     * @return Collection<int, Bookings>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Bookings $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Bookings $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bookings>
     */
    public function getBooking(): Collection
    {
        return $this->bookings;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderCake(): Collection
    {
        return $this->orderCake;
    }

    public function addOrderCake(Order $orderCake): self
    {
        if (!$this->orderCake->contains($orderCake)) {
            $this->orderCake[] = $orderCake;
            $orderCake->setUser($this);
        }

        return $this;
    }

    public function removeOrderCake(Order $orderCake): self
    {
        if ($this->orderCake->removeElement($orderCake)) {
            // set the owning side to null (unless already changed)
            if ($orderCake->getUser() === $this) {
                $orderCake->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CakeDelivery>
     */
    public function getDelivery(): Collection
    {
        return $this->delivery;
    }

    public function addDelivery(CakeDelivery $delivery): self
    {
        if (!$this->delivery->contains($delivery)) {
            $this->delivery[] = $delivery;
            $delivery->setUser($this);
        }

        return $this;
    }

    public function removeDelivery(CakeDelivery $delivery): self
    {
        if ($this->delivery->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getUser() === $this) {
                $delivery->setUser(null);
            }
        }

        return $this;
    }


}
