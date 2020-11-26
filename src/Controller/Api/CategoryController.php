<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller\Api
 *
 * @Route("/api")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository)
    {
        return $this->json([
            'response' => 'ok',
            'data' => $categoryRepository->getArrayAllCategories()
        ], Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/categories/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function single(int $id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->getCategoryById($id);
        if (!$category) {
            return $this->json([
                'response' => 'Not Found'
            ], Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
        }

        return $this->json([
            'response' => Response::HTTP_OK,
            'data' => $category
        ], Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
