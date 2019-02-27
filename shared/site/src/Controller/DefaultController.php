<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sylius\Component\Product\Repository\ProductRepositoryInterface;
use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductRepository;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use App\Form\OrderType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="home", methods={"GET"})
     * @param Request         $request
     *
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function indexAction(Request $request, ProductFactoryInterface $factory)
    {
        $product = $factory->createNew();

        $product->setName("Детский шарф");
        $product->setCode(10000);
        $product->setSlug("sharf");
        $product->setDescription("Детский шарф для детей 2-3 года");

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        dd('ok');

    }

    /**
     * @Route("/myform/{id}", name="myform")
     * @param Request         $request
     *
     */
    public function myFormAction(Order $order, Request $request)
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }
        return $this->render('default/add_order.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
