<?php

declare(strict_types=1);

namespace Belous\ProductsBundle\Controller;


use Belous\ProductsBundle\Entity\Product;
use Belous\ProductsBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var Product $productType */
            $productType = $form->getData();
            $em->persist($productType);
            $em->flush();

            return $this->redirectToRoute('product_edit', ['id' => $productType->getId()]);
        }

        return $this->render('@BelousProducts/Product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function edit(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('@BelousProducts/Product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('@BelousProducts/Product/list.html.twig', [
            'products' => $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll()
        ]);
    }
}