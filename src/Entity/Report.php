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

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_report = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    private ?Post $post_report = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    private ?Comment $comment_report = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    private ?Message $message_report = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    private ?File $file_report = null;

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

    public function getPostReport(): ?Post
    {
        return $this->post_report;
    }

    public function setPostReport(?Post $post_report): static
    {
        $this->post_report = $post_report;

        return $this;
    }

    public function getCommentReport(): ?Comment
    {
        return $this->comment_report;
    }

    public function setCommentReport(?Comment $comment_report): static
    {
        $this->comment_report = $comment_report;

        return $this;
    }

    public function getMessageReport(): ?Message
    {
        return $this->message_report;
    }

    public function setMessageReport(?Message $message_report): static
    {
        $this->message_report = $message_report;

        return $this;
    }

    public function getFileReport(): ?File
    {
        return $this->file_report;
    }

    public function setFileReport(?File $file_report): static
    {
        $this->file_report = $file_report;

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
}
