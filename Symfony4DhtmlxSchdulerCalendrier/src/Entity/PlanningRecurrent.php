<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRecurrentRepository")
 */
class PlanningRecurrent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $event_length;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rec_type;

    /*/**
     * @ORM\Column(type="bigint", nullable=true)
     */
    /*private $event_pid;*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getEventLength(): ?int
    {
        return $this->event_length;
    }

    public function setEventLength(?int $event_length): self
    {
        $this->event_length = $event_length;

        return $this;
    }

    public function getRecType(): ?string
    {
        return $this->rec_type;
    }

    public function setRecType(?string $rec_type): self
    {
        $this->rec_type = $rec_type;

        return $this;
    }

    /*public function getEventPid(): ?int
    {
        return $this->event_pid;
    }

    public function setEventPid(?int $event_pid): self
    {
        $this->event_pid = $event_pid;

        return $this;
    }*/
}
