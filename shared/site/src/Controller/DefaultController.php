<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\OrderType;
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
     */
    public function indexAction(Request $request)
    {

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
     */
    public function some(Request $request, OrderRepository $orderRepository)
    {
        $o = $orderRepository->getSome();

        dd($o);
    }
}
