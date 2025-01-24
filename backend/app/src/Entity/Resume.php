<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["resume:read", "resume:write"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $profession = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:20)]
    #[Assert\NotNull]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Email]
    #[Assert\Length(max:255)]
    #[Assert\NotNull]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\Column]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Positive]
    #[Assert\NotNull]
    private ?float $salary = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max: 2048)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $about = null;

    #[ORM\Column(length: 255)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $skills = null;

    /**
     * @var Collection<int, Education>
     */
    #[ORM\ManyToMany(targetEntity: Education::class, inversedBy: 'resumes', cascade: ["persist"])]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Valid]
    private Collection $educations;

    #[ORM\ManyToOne(inversedBy: 'resumes', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Valid]
    private ?ResumeStatus $status = null;

    #[ORM\Column(length: 2048, nullable: true)]
    #[Groups(["resume:read", "resume:write"])]
    #[Assert\Length(max:2048)]
    private ?string $photo = null;

    public function __construct()
    {
        $this->educations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeImmutable $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): static
    {
        $this->about = $about;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): static
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        $this->educations->removeElement($education);

        return $this;
    }

    public function getStatus(): ?ResumeStatus
    {
        return $this->status;
    }

    public function setStatus(?ResumeStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }
}
