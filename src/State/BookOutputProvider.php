<?php 

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\BookOutput;
use App\Entity\Book;

class BookOutputProvider implements ProviderInterface
{
    public function __construct(private ProviderInterface $itemProvider)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $book = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$book instanceof Book) {
            return null;
        }

        $bookOutput = new BookOutput();
        $bookOutput->id = $book->getId();
        $bookOutput->title = $book->getTitle();
        $bookOutput->author = $book->getAuthor();

        $bookOutput->publishedDate = $book->getPublishedAt()->format('d/m/Y');
        
        $age = $book->getPublishedAt()->diff(new \DateTime())->y;
        $bookOutput->age = $age . ' ans';

        return $bookOutput;
    }
}