<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $reason_reporting = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_report = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $report_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserReport(): ?User
    {
        return $this->user_report;
    }

    public function setUserReport(?User $user_report): static
    {
        $this->user_report = $user_report;

        return $this;
    }

    public function getReportAt(): ?\DateTimeImmutable
    {
        return $this->report_at;
    }

    public function setReportAt(\DateTimeImmutable $report_at): static
    {
        $this->report_at = $report_at;

        return $this;
    }

    public function getReasonReporting(): ?string
    {
        return $this->reason_reporting;
    }

    public function setReasonReporting(string $reasonReporting): static
    {
        $this->reason_reporting = $reasonReporting;
        return $this;
    }
}
