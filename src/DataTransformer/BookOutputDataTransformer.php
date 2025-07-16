<?php

namespace App\DataTransformer;

use ApiPlatform\State\TransformerInterface;
use App\Dto\BookOutput;
use App\Entity\Book;

final class BookOutputDataTransformer implements TransformerInterface
{
    public function transform(
        object $object,
        string $to,
        array $context = []
    ): BookOutput {
        $output = new BookOutput();
        $output->id = $object->getId();
        $output->title = $object->getTitle();
        $output->author = $object->getAuthor();

        $output->publishedDate = $object->getPublishedAt()->format('Y-m-d');

        return $output;
    }

    public function supportsTransformation(
        mixed $data,
        string $to,
        array $context = []
    ): bool {
        return $data instanceof Book && $to === BookOutput::class;
    }
}
