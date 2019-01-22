<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GradesRepository")
 */
class Grades
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Courses", inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrades(): ?float
    {
        return $this->grade;
    }

    public function setGrades(float $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getCourses(): ?Courses
    {
        return $this->course;
    }

    public function setCourses(?Courses $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getStudents(): ?User
    {
        return $this->student;
    }

    public function setStudents(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comment;
    }

    public function setComments(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
