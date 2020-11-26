<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller\Api
 *
 * @Route("/api")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/products", methods={"GET"})
     */
    public function list(ProductRepository $productRepository)
    {
        $request = Request::createFromGlobals();

        $parameters = [
            'min' => (int) $request->get('min') ?? null,
            'max' => (int) $request->get('max') ?? null,
        ];

        return $this->json([
            'response' => 'ok',
            'data' => $productRepository->getArrayAllProducts($parameters)
        ], Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/products/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function single(int $id, ProductRepository $productRepository)
    {
        $product = $productRepository->getProductById($id);

        if (!$product) {
            return $this->json([
                'response' => 'Not Found'
            ], Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
        }

        return $this->json([
            'response' => 'ok',
            'data' => $product
        ], Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/products/search", methods={"POST"})
     */
    public function search(ProductRepository $productRepository)
    {
        $request = Request::createFromGlobals();

        if (!$request->get('search')) {
            return $this->json([
                'response' => 'Missing parameter'
            ], Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }

        $products = $productRepository->search($request->get('search'));

        return $this->json([
            'response' => 'ok',
            'data' => $products
        ], Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
