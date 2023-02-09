<?php

namespace App\Entity;

use App\Entity\Traits\BlameTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\Interfaces\BlameInterface;
use App\Entity\Traits\Interfaces\IdentifierInterface;
use App\Entity\Traits\Interfaces\TimestampInterface;
use App\Entity\Traits\TimestampTrait;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Comment implements IdentifierInterface, TimestampInterface, BlameInterface
{
    use IdentifierTrait {
        IdentifierTrait::__construct as private __identifierConstruct;
    }
    use TimestampTrait;
    use BlameTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;
    #[ORM\Column(length: 2048)]
    private ?string $description = null;
    #[ORM\Column(nullable: true)]
    private ?int $target = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?CommentNotation $commentNotation = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    public ?Article $article = null;

    public function __construct(){
        $this-> __identifierConstruct();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCommentNotation(): ?CommentNotation
    {
        return $this->commentNotation;
    }

    public function setCommentNotation(?CommentNotation $commentNotation): self
    {
        $this->commentNotation = $commentNotation;

        return $this;
    }

    public function getTarget(): ?int
    {
        return $this->target;
    }

    public function setTarget(?int $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
