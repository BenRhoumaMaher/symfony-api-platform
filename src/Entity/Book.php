<?php

namespace App\Entity;

use App\Dto\BookInput;
use App\Dto\BookOutput;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\RecentBooksController;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
        new GetCollection(),
        new Post(
            input: 
            [
            'class' => BookInput::class,
            'transformer' => BookInputDataTransformer::class
            ]
        ),
        new Get(
            output: BookOutput::class, 
            provider: BookOutputProvider::class
        ),
        new GetCollection(
            uriTemplate: '/books/recent',
            controller: RecentBooksController::class,
        ),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ['title' => 'partial', 'author' => 'exact']
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title cannot be blank.")]
    #[Assert\Length(min: 3, max: 255)]
    #[ApiProperty(types: ['http://127.0.0.1:8000/api'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $author = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTime $publishedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
