<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sylius\Component\Product\Repository\ProductRepositoryInterface;
use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductRepository;
use App\Form\OrderType;

class ProgrammerController extends AbstractController
{
    /**
     * @Route("/api/programmers", name="programmers", methods={"POST"})
     * @param Request         $request
     *
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        return new JsonResponse(['msg' => "hello"], 200);
    }

    /**
     * @Route("/api/catch", name="catch")
     * @param Request         $request
     *
     * @return JsonResponse
     */
    public function myFormAction(Request $request)
    {
        $team = $request->request->get("team");
        return new JsonResponse(['team' => $team], 200);
    }
}
