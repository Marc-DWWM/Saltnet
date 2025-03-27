<?php

namespace App\Entity;

use App\Repository\FollowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowerRepository::class)]
class Follower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Relation pour "user_follower" (celui qui suit)
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userFollowers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_follower = null;

    // Relation pour "follower" (celui qui est suivi)
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'followers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $follower = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $follower_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserFollower(): ?User
    {
        return $this->user_follower;
    }

    public function setUserFollower(?User $user_follower): static
    {
        $this->user_follower = $user_follower;

        return $this;
    }

    public function getFollower(): ?User
    {
        return $this->follower;
    }

    public function setFollower(?User $follower): static
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowerAt(): ?\DateTimeImmutable
    {
        return $this->follower_at;
    }

    public function setFollowerAt(\DateTimeImmutable $follower_at): static
    {
        $this->follower_at = $follower_at;

        return $this;
    }
}
