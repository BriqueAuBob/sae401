<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $pkey = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pvalue = null;

    #[ORM\Column(length: 10)]
    private ?string $ptype = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user_id;
    }

    public function setUser(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPkey(): ?string
    {
        return $this->pkey;
    }

    public function setPkey(string $pkey): static
    {
        $this->pkey = $pkey;

        return $this;
    }

    public function getPvalue(): ?string
    {
        return $this->pvalue;
    }

    public function setPvalue($pvalue): static
    {
        switch(gettype($pvalue)) {
            case 'array':
            case 'object':
                $this->setPtype('JSON');
                $pvalue = json_encode($pvalue);
                break;
            case 'integer':
            case 'double':
                $this->setPtype('NUMBER');
                break;
            case 'boolean':
                $this->setPtype('BOOLEAN');
                break;
            default:
                $this->setPtype('STRING');
        }
        $this->pvalue = (string)$pvalue;

        return $this;
    }

    public function getPtype(): ?string
    {
        return $this->ptype;
    }

    public function setPtype(string $ptype): static
    {
        $this->ptype = $ptype;

        return $this;
    }

    public function getCastedValue() {
        switch($this->getPtype()) {
            case 'JSON':
                return json_decode($this->getPvalue());
            case 'NUMBER':
                return (integer)$this->getPvalue();
            case 'BOOLEAN':
                return (bool)$this->getPvalue();
            default:
                return $this->getPvalue();
        }
    }
}
