<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Choice(
        choices: ['perfect', 'good', 'average', 'bad'],
        message: 'The status must be one of the following: {{ choices }}'
    )]
    #[Assert\NotBlank(message: 'The status of the item is required')]
    #[ORM\Column(length: 10)]
    private ?string $status = null;

    #[ORM\Column]
    private ?bool $available = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Assert\NotBlank(message: 'The type of game is required')]
    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\OneToMany(mappedBy: 'firstItem', targetEntity: ItemTrade::class, orphanRemoval: true)]
    private Collection $itemTrades;

    public function __construct()
    {
        $this->itemTrades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection<int, ItemTrade>
     */
    public function getItemTrades(): Collection
    {
        return $this->itemTrades;
    }

    public function addItemTrade(ItemTrade $itemTrade): static
    {
        if (!$this->itemTrades->contains($itemTrade)) {
            $this->itemTrades->add($itemTrade);
            $itemTrade->setFirstItem($this);
        }

        return $this;
    }

    public function removeItemTrade(ItemTrade $itemTrade): static
    {
        if ($this->itemTrades->removeElement($itemTrade)) {
            // set the owning side to null (unless already changed)
            if ($itemTrade->getFirstItem() === $this) {
                $itemTrade->setFirstItem(null);
            }
        }

        return $this;
    }
}
