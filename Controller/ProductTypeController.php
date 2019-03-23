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
    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_TYPE_CREATE');

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

    /**
     * @param ProductType $productType
     * @param Request $request
     * @return Response
     */
    public function edit(ProductType $productType, Request $request): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_TYPE_EDIT', $productType);

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

    /**
     * @return Response
     */
    public function list():Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_TYPE_LIST');

        return $this->render('@BelousProducts/ProductType/list.html.twig', [
            'types' => $this->getDoctrine()->getManager()->getRepository(ProductType::class)->findAll()
        ]);
    }

}