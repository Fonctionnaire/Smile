<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addDate;



    /**
     * @ORM\Column(type="text")
     */
    private $frContent;

    /**
     * @ORM\Column(type="text")
     */
    private $enContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    public function __construct()
    {
        $this->addDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }


    public function getFrContent(): ?string
    {
        return $this->frContent;
    }

    public function setFrContent(string $frContent): self
    {
        $this->frContent = $frContent;

        return $this;
    }

    public function getEnContent(): ?string
    {
        return $this->enContent;
    }

    public function setEnContent(string $enContent): self
    {
        $this->enContent = $enContent;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }
}
