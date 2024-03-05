<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/utilisateurs/{id}',
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'utilisateur:item']
        ),
        new GetCollection(
            uriTemplate: '/utilisateurs',
            normalizationContext: ['groups' => 'utilisateur:list']
        ),
        new Post(
            uriTemplate: 'utilisateurs/add',
            status : 301,
        ),
        new Delete(
            uriTemplate: '/utilisateurs/{id}',
            requirements: ['id' => '\d+'],           
        ),
    ],
    order: ['id' => 'ASC', 'nom' => 'ASC', 'prenom'=>'ASC', 'urlImg'=>'ASC'],
    paginationEnabled: true
)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api', 'utilisateur:item', 'utilisateur:list', 'article:list','article:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'utilisateur:item', 'utilisateur:list', 'article:list','article:item'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'utilisateur:item', 'utilisateur:list', 'article:list','article:item'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['utilisateur:item', 'utilisateur:list', 'article:list','article:item'])]
    private ?string $urlImg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUrlImg(): ?string
    {
        return $this->urlImg;
    }

    public function setUrlImg(string $urlImg): static
    {
        $this->urlImg = $urlImg;

        return $this;
    }
    public function __toString() : string 
    {
        return $this->prenom . " " . $this->nom;
    }
}
