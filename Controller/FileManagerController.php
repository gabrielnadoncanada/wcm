<?php

namespace Nadmin\WcmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FileManagerController extends AbstractController
{

    /**
     * @Route("/admin/filemanager", name="filemanager_index", methods={"GET"})
     */
    public function index()
    {

        return $this->render('@Wcm/filemanager/index.html.twig', [

        ]);
    }


}
