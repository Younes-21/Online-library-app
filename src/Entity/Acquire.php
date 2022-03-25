<?php

namespace App\Entity;

use App\Repository\AcquireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AcquireRepository::class)
 */
class Acquire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $acquire_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="acquire")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="acquire")
     */
    private $book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcquireDate(): ?\DateTimeInterface
    {
        return $this->acquire_date;
    }

    public function setAcquireDate(\DateTimeInterface $acquire_date): self
    {
        $this->acquire_date = $acquire_date;

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

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
