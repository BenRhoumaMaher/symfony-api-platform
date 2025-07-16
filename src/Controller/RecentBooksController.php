<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RecentBooksController
{
    public function __invoke(
        EntityManagerInterface $em
    ) {
        $books = $em->getRepository(
            Book::class
        )
            ->findBy(
                [],
                ['publishedAt' => 'DESC'],
                5
            );
        return new JsonResponse($books);
    }
}
