<?php

namespace App\Entity;

use App\Repository\LivreCommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: LivreCommandeRepository::class)]
class LivreCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column()]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'livreCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'livreCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;


    public function __construct(Commande $commande, Livre $livre, int $quantite)
    {
        $this->commande = $commande;
        $this->livre = $livre;
        $this->quantite = $quantite;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): void
    {
        $this->quantite = $quantite;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }
}