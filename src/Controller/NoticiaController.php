<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NoticiaController extends AbstractController
{
    /**
     * @Route("/noticia", name="noticiac")
     */
    public function index()
    {
        return $this->redirectToRoute('noticia');
    }
}
