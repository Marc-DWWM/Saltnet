<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_post = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $post = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'reposts', cascade: ['remove'])]
    #[ORM\JoinColumn(name: 'original_post_id', referencedColumnName: 'id', nullable: true)]
    private ?Post $originalPost = null;

    #[ORM\OneToMany(mappedBy: 'originalPost', targetEntity: Post::class, cascade: ['remove'])]
    private Collection $reposts;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post_comment', cascade: ['remove'])]
    private Collection $comments;

    /**
     * @var Collection<int, Like>
     */
    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'post_like')]
    private Collection $likes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->reposts = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPhoto(): ?string
    {
        return $this->user_post ? $this->user_post->getPhoto() : null;
    }


    public function getUserPost(): ?User
    {
        return $this->user_post;
    }

    public function setUserPost(?User $user_post): static
    {
        $this->user_post = $user_post;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPostComment($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPostComment() === $this) {
                $comment->setPostComment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setPostLike($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPostLike() === $this) {
                $like->setPostLike(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getReposts(): Collection
    {
        return $this->reposts;
    }

    public function addRepost(Post $repost): static
    {
        if (!$this->reposts->contains($repost)) {
            $this->reposts->add($repost);
            $repost->setOriginalPost($this);
        }

        return $this;
    }

    public function removeRepost(Post $repost): static
    {
        if ($this->reposts->removeElement($repost)) {
            // set the owning side to null (unless already changed)
            if ($repost->getOriginalPost() === $this) {
                $repost->setOriginalPost(null);
            }
        }

        return $this;
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
}
