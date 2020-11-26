<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=2, max=500)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Realization::class, inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realization;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRealization(): ?Realization
    {
        return $this->realization;
    }

    public function setRealization(?Realization $realization): self
    {
        $this->realization = $realization;

        return $this;
    }
}
