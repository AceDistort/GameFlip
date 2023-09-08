<?php

namespace App\Entity;

use App\Repository\ItemTradeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemTradeRepository::class)]
class ItemTrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $tradeDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $returnDate = null;

    #[ORM\ManyToOne(inversedBy: 'itemTrades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $firstItem = null;

    #[ORM\ManyToOne(inversedBy: 'itemTrades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $secondItem = null;

    #[ORM\Column]
    private ?bool $isProposal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTradeDate(): ?\DateTimeInterface
    {
        return $this->tradeDate;
    }

    public function setTradeDate(\DateTimeInterface $tradeDate): static
    {
        $this->tradeDate = $tradeDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getFirstItem(): ?Item
    {
        return $this->firstItem;
    }

    public function setFirstItem(?Item $firstItem): static
    {
        $this->firstItem = $firstItem;

        return $this;
    }

    public function getSecondItem(): ?Item
    {
        return $this->secondItem;
    }

    public function setSecondItem(?Item $secondItem): static
    {
        $this->secondItem = $secondItem;

        return $this;
    }

    public function isIsProposal(): ?bool
    {
        return $this->isProposal;
    }

    public function setIsProposal(bool $isProposal): static
    {
        $this->isProposal = $isProposal;

        return $this;
    }
}
