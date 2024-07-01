<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class IndexController extends AbstractController
{
    private const int PER_PAGE = 6;

    #[Route('/{page<\d+>}', name: 'app_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, int $page = 1): Response
    {
        $article = $articleRepository->find('swup');
        $articles = $articleRepository->findAll();
        $pages = ceil(\count($articles) / self::PER_PAGE);
        $results = \array_slice($articles, ($page - 1) * self::PER_PAGE, self::PER_PAGE);

        return $this->render('index.html.twig', [
            'article' => $article,
            'results' => $results,
            'page' => $page,
            'pages' => $pages,
        ]);
    }
}
