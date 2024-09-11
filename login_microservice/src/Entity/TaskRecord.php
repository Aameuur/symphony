<?php
// src/Entity/TaskRecord.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRecordRepository::class)]
class TaskRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $agentId;

    #[ORM\Column(type: 'integer')]
    private $taskId;

    #[ORM\Column(type: 'datetime')]
    private $startTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endTime;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'float', nullable: true)]
    private $distanceTraveled;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgentId(): ?int
    {
        return $this->agentId;
    }

    public function setAgentId(int $agentId): self
    {
        $this->agentId = $agentId;

        return $this;
    }

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDistanceTraveled(): ?float
    {
        return $this->distanceTraveled;
    }

    public function setDistanceTraveled(?float $distanceTraveled): self
    {
        $this->distanceTraveled = $distanceTraveled;

        return $this;
    }
}
