<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/article/upload/test", name="upload_test")
     */
    public function index(Request $request)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');

        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
        $uploadedFile->move($destination, $uploadedFile->getClientOriginalName());

        return $this->render('article_admin/index.html.twig', [
            'controller_name' => 'ArticleAdminController',
        ]);
    }
}
