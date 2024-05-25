<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type:'string',length: 100)]
    private ?string $ISBN = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type:'string',length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\Column(type:'float',length: 255)]
    private ?float $prix = null;

    #[ORM\Column(type:'integer', length: 255)]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'livres')]
    private Collection $auteur;

    /**
     * @var Collection<int, LivreCommande>
     */
    #[ORM\OneToMany(targetEntity: LivreCommande::class, mappedBy: 'livre', cascade: ["persist"], orphanRemoval: true)]
    private Collection $livreCommandes;

    public function __construct()
    {
        $this->auteur = new ArrayCollection();
        $this->livreCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur->add($auteur);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteur->removeElement($auteur);

        return $this;
    }


    public function addCommande(Commande $commande, int $quantite): static
    {
        foreach ($this->livreCommandes as $existingCommande) {
            if ($existingCommande->getCommande()->getId() === $commande->getId()) {
                return $this;
            }
        }

        // If the commande doesn't exist in the collection, add it
        $livreCommande = new LivreCommande();
        $livreCommande->setLivre($this);
        $livreCommande->setCommande($commande);
        $livreCommande->setQuantite($quantite);

        $this->livreCommandes->add($livreCommande);
        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        foreach ($this->livreCommandes as $key => $livreCommande) {
            if ($livreCommande->getCommande() === $commande) {
                $this->livreCommandes->removeElement($livreCommande);
                $commande->removeLivre($this);
                break;
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LivreCommande>
     */
    public function getLivreCommandes(): Collection
    {
        return $this->livreCommandes;
    }

    public function addLivreCommande(LivreCommande $livreCommande): static
    {
        if (!$this->livreCommandes->contains($livreCommande)) {
            $this->livreCommandes->add($livreCommande);
            $livreCommande->setLivre($this);
        }

        return $this;
    }

    public function removeLivreCommande(LivreCommande $livreCommande): static
    {
        if ($this->livreCommandes->removeElement($livreCommande)) {
            // set the owning side to null (unless already changed)
            if ($livreCommande->getLivre() === $this) {
                $livreCommande->setLivre(null);
            }
        }

        return $this;
    }
}
