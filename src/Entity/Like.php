<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`', uniqueConstraints: [
    new ORM\UniqueConstraint(name: "user_post_unique", columns: ["user_like_id", "post_like_id"])
])]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_like = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post_like = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $like_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLike(): ?User
    {
        return $this->user_like;
    }

    public function setUserLike(?User $user_like): static
    {
        $this->user_like = $user_like;

        return $this;
    }

    public function getPostLike(): ?Post
    {
        return $this->post_like;
    }

    public function setPostLike(?Post $post_like): static
    {
        $this->post_like = $post_like;

        return $this;
    }

    public function getLikeAt(): ?\DateTimeImmutable
    {
        return $this->like_at;
    }

    public function setLikeAt(\DateTimeImmutable $like_at): static
    {
        $this->like_at = $like_at;

        return $this;
    }
}
