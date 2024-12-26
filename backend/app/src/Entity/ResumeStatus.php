<?php

namespace App\Entity;

use App\Repository\ResumeStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeStatusRepository::class)]
class ResumeStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["resume:read", "resume:write"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:255)]
    private ?string $value = null;

    /**
     * @var Collection<int, Resume>
     */
    #[ORM\OneToMany(targetEntity: Resume::class, mappedBy: 'status', orphanRemoval: true)]
    private Collection $resumes;

    public function __construct()
    {
        $this->resumes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Resume>
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }

    public function addResume(Resume $resume): static
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes->add($resume);
            $resume->setStatus($this);
        }

        return $this;
    }

    public function removeResume(Resume $resume): static
    {
        if ($this->resumes->removeElement($resume)) {
            // set the owning side to null (unless already changed)
            if ($resume->getStatus() === $this) {
                $resume->setStatus(null);
            }
        }

        return $this;
    }
}
