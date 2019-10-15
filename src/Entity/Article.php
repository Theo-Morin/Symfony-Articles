<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=5,max=50,minMessage="Le libelle doit faire au moins 5 caractères",maxMessage="Le libelle ne doit pas dépasser 50 caractères")
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min=0,max=500,minMessage="Le prix doit être minimum 0",maxMessage="Le prix ne peut pas dépasser 500€")
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Asset/NotBlank()
     * @Assert\Length(min=10,max=200,minMessage="La description ne peut pas être vide !",maxMessage="La description doit contenir au maximum 200 caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
