<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $book_img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $edition;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $resume;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="books")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Acquire::class, mappedBy="book")
     */
    private $acquire;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="book")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $book_content;

    public function __construct()
    {
        $this->acquire = new ArrayCollection();
        $this->comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBookImg(): ?string
    {
        return $this->book_img;
    }

    public function setBookImg(string $book_img): self
    {
        $this->book_img = $book_img;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(string $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, Acquire>
     */
    public function getAcquire(): Collection
    {
        return $this->acquire;
    }

    public function addAcquire(Acquire $acquire): self
    {
        if (!$this->acquire->contains($acquire)) {
            $this->acquire[] = $acquire;
            $acquire->setBook($this);
        }

        return $this;
    }

    public function removeAcquire(Acquire $acquire): self
    {
        if ($this->acquire->removeElement($acquire)) {
            // set the owning side to null (unless already changed)
            if ($acquire->getBook() === $this) {
                $acquire->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getBookContent(): ?string
    {
        return $this->book_content;
    }

    public function setBookContent(string $book_content): self
    {
        $this->book_content = $book_content;

        return $this;
    }
}
