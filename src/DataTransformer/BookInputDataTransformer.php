<?php

namespace App\DataTransformer;

use DateTime;
use App\Entity\Book;
use App\Dto\BookInput;
use ApiPlatform\Dto\DtoInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\DtoInputTransformerInterface;

class BookInputDataTransformer implements DtoInputTransformerInterface
{
    public function transform(
        mixed $object,
        Operation $operation,
        array $context = []
    ): object {
        $book = new Book();
        $book->setTitle($object->title);
        $book->setAuthor($object->author);
        $book->setPublishedAt(
            DateTime::createFromFormat(
                'Y/m/d',
                $object->publishedDate
            )
        );
        return $book;
    }
    public function supports(
        mixed $data,
        Operation $operation,
        array $context = []
    ): bool {
        return $data instanceof BookInput;
    }
}
