<?php

declare(strict_types=1);

namespace Belous\ProductsBundle\Controller;

use Belous\ProductsBundle\Entity\ProductType;
use Belous\ProductsBundle\Form\ProductTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeController extends Controller
{
    public function create(Request $request): Response
    {
        $form = $this->createForm(ProductTypeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var ProductType $productType */
            $productType = $form->getData();
            $em->persist($productType);
            $em->flush();

            return $this->redirectToRoute('product_type_edit', ['id' => $productType->getId()]);
        }

        return $this->render('@BelousProducts/ProductType/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    public function edit(ProductType $productType, Request $request): Response
    {
        $form = $this->createForm(ProductTypeType::class, $productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('@BelousProducts/ProductType/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    public function list():Response
    {
        return $this->render('@BelousProducts/ProductType/list.html.twig', [
            'types' => $this->getDoctrine()->getManager()->getRepository(ProductType::class)->findAll()
        ]);
    }

}