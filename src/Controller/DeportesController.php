<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeportesController {
    /**
     * @Route("/")
     */
    public function inicio() {
        return new Response('Mi primera pagina en Symfony!');
    }
    /**
     * @Route("/deportes/primer-articulo")
     */
    public function mostrar()
    {
        return new Response('Mi primera ruta Primer Artículo!');
    }
}
