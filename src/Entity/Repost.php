<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RepostRepository;

#[ORM\Entity(repositoryClass: RepostRepository::class)]
class Repost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $originalPost = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userRepost = null;


    #[ORM\Column(type: "datetime")]
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalPost(): ?Post
    {
        return $this->originalPost;
    }

    public function setOriginalPost(?Post $originalPost): self
    {
        $this->originalPost = $originalPost;
        return $this;
    }

    public function getUserRepost(): ?User
    {
        return $this->userRepost;
    }

    public function setUserRepost(?User $userRepost): self
    {
        $this->userRepost = $userRepost;
        return $this;
    }


    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
