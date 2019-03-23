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
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\HttpFoundation\File\Base64UploadFile;
use App\Repository\OrderRepository;

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

    /**
     * @Route("/base", name="base_image")
     * @param Request         $request
     *
     * @return JsonResponse
     */
    public function baseAction(Request $request)
    {

        // https://www.youtube.com/watch?v=eX37-ViljIg

        $base64File = $request->request->get('some', null);
        if ($base64File) {
            $objFile = new Base64UploadFile($base64File);

            $arrFiles = $request->files->get("tenant");


            $path = $this->getParameter('base64_upload_path');
            $fileName = (string)uniqid(time());

            $fullName = $fileName . "." . $objFile->getMimeType();

            try {
                $ss = $objFile->getClientMimeType();
                $objFile->move($path, $fullName);

            } catch (FileException $e) {

            }


            // или засунуть его в реквест и далее обработать через форму
            $arrFiles['image']['file'] = $objFile;
            $request->files->set("tenant", $arrFiles);

            return new JsonResponse(['msg' => $ss], 200);

        } else {
            return new JsonResponse(['msg' => 'nope'], 200);
        }
    }

    /**
     * @Route("/some", name="some", methods={"GET"})
     * @param Request         $request
     *
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function some(Request $request, OrderRepository $orderRepository)
    {
        $o = $orderRepository->getSome();

        dd($o);
    }
}
