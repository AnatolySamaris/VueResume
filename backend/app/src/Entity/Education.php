<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EducationRepository::class)]
class Education
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 512, nullable: true)]
    #[Groups(["resume:read", "resume:write"])]
    private ?string $place = null;

    #[ORM\Column(length: 512, nullable: true)]
    #[Groups(["resume:read", "resume:write"])]
    private ?string $faculty = null;

    #[ORM\Column(length: 512, nullable: true)]
    #[Groups(["resume:read", "resume:write"])]
    private ?string $specialty = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["resume:read", "resume:write"])]
    private ?int $endYear = null;

    #[ORM\ManyToOne(inversedBy: 'education', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Valid]
    private ?EducationLevel $level = null;

    /**
     * @var Collection<int, Resume>
     */
    #[ORM\ManyToMany(targetEntity: Resume::class, mappedBy: 'educations')]
    private Collection $resumes;

    public function __construct()
    {
        $this->resumes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    public function setFaculty(?string $faculty): static
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getSpecialty(): ?string
    {
        return $this->specialty;
    }

    public function setSpecialty(?string $specialty): static
    {
        $this->specialty = $specialty;

        return $this;
    }

    public function getEndYear(): ?int
    {
        return $this->endYear;
    }

    public function setEndYear(?int $endYear): static
    {
        $this->endYear = $endYear;

        return $this;
    }

    public function getLevel(): ?EducationLevel
    {
        return $this->level;
    }

    public function setLevel(?EducationLevel $level): static
    {
        $this->level = $level;

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
            $resume->addEducation($this);
        }

        return $this;
    }

    public function removeResume(Resume $resume): static
    {
        if ($this->resumes->removeElement($resume)) {
            $resume->removeEducation($this);
        }

        return $this;
    }
}
