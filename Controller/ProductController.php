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

    public function create(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('PRODUCT_CREATE');

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


    public function edit(Product $product, Request $request): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
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

    public function list():Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_LIST');

        return $this->render('@BelousProducts/Product/list.html.twig', [
            'products' => $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll()
        ]);
    }
}