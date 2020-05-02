<?php
namespace App\Controller;
use App\Entity\Noticia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class DeportesController extends Controller {
    /**
     * @Route("/")
     */
    public function inicio() {
        return $this->render("base.html.twig");
    }
    /**
     * @Route("/deportes/cargarbd", name="noticia" )
     */
    public function cargarBD() {
        $em=$this->getDoctrine()->getManager();
        $noticia = new Noticia();
        $noticia->setSeccion("Tenis");
        $noticia->setEquipo("Novak-Djokovich");
        $noticia->setFecha("18022018");
        $noticia->setTextoTitular("Otra-mas");
        $noticia->setTextoNoticia("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec imperdiet nisl, quis imperdiet magna. Aliquam dolor quam, consequat ut blandit eget, consequat ut turpis. Phasellus ac elit nisl. Aenean luctus ante sit amet bibendum lobortis. Morbi nulla urna, facilisis at eleifend sit amet, porta convallis quam. Aenean molestie a erat gravida convallis. Donec efficitur imperdiet risus, porttitor molestie eros semper non. Nullam quis condimentum erat. Etiam tincidunt laoreet turpis sit amet porta. Ut hendrerit nisi sed dictum auctor. Sed sed dui purus. Nulla eget leo metus. Suspendisse bibendum sit amet magna eu accumsan. Mauris eu ex pretium, vulputate diam eu, pulvinar odio.");
        $noticia->setImagen('novak.jpg');
        $em->persist($noticia);
        $em->flush();
        return new Response("Noticia guardada con éxito con id:".$noticia->getId());
    }
    /**
     * @Route("/deportes/actualizarbd", name="actualizarNoticia" )
     */
    public function actualizarBD(Request $request) {
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $noticia = $em->getRepository(Noticia::class)->find($id);
        $noticia->setSeccion("Tenis");
        $noticia->setEquipo("roger-federer");
        $noticia->setFecha("17022018");
        $noticia->setTextoTitular("Roger-Federer-a-una-victoria-del-número-uno-de-Nadal");
        $noticia->setTextoNoticia("El suizo Roger Federer, el tenista más laureado de la historia, está a son un paso de regresar a la cima del tenis mundial a sus 36 años. Clasificado sin admitir ni réplica para cuartos de final del torneo de Rotterdam, si vence este viernes a Robin Haase se convertirá en el número uno del mundo...");
        $noticia->setImagen('federer.jpg');
        $em->persist($noticia);
        $em->flush();
        return new Response("Noticia actualizada con id:".$noticia->getId());
    }
    /**
     * @Route("/deportes/eliminar", name="eliminarNoticia" )
     */
    public function eliminarBD(Request $request) {
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $noticia = $em->getRepository(Noticia::class)->find($id);
        $newId=$noticia->getId();
        $em->remove($noticia);
        $em->flush();
        return new Response("Noticia con id:".$newId." eliminada");
    }


    /**
     * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas", requirements={"pagina"="\d+"},
     *     defaults={"pagina":"tenis"})))
     */
    public function lista($seccion, $pagina = 1)
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Noticia::class);
        //Buscamos las noticias de una sección
        $noticiaSec= $repository->findOneBy(['seccion' => $seccion]);
        // Si la sección no existe saltará una excepción
        if(!$noticiaSec) {
            throw $this->createNotFoundException('Error 404 este deporte no está en nuestra Base de Datos');
        }
        // Almacenamos todas las noticias de una sección en una lista
        $noticias = $repository->findBy(["seccion"=>$seccion]);
        return $this->render('noticia/listar.html.twig', [
                // La función str_replace elimina los símbolos - de los títulos
                'titulo' => ucwords(str_replace('-', ' ', $seccion)),
                'noticias'=>$noticias
                ]);
    }
    /**
     * @Route("/deportes/{seccion}/{slug}", name="verNoticia",
     * defaults={"seccion":"tenis"})
     */
    public function noticia($slug, $seccion) {
       $em=$this->getDoctrine()->getManager();
       $repository = $this->getDoctrine()->getRepository(Noticia::class);
       $noticia = $repository->findOneBy(['textoTitular' => $slug]);
       //no noticia error 404
        if (!$noticia){
            //throw $this->createNotFoundException('Error 404: El deporte no está en la base de datos');
            return $this->render("base.html.twig",['texto'=>"Error 404 Pagina no encontrada"]);
        }
        return $this->render('noticia/noticia.html.twig', [
            //Parser del titulo para quitar guiones
            'titulo' => ucwords(str_replace('-', ' ', $slug)),
            'noticias' => $noticia
        ]);
    }

    /**
     * @Route(
     *     "/deportes/{_locale}/{fecha}/{seccion}/{equipo}/{pagina}",
     *     defaults={"_format":"html","pagina":"1"},
     *     requirements={
     *         "_locale": "es|en",
     *         "_format": "html|json|xml",
     *         "fecha": "[\d+]{8}",
     *         "pagina"="\d+"
     *     }
     * )
     */
    public function rutaAvanzadaListado($_locale, $fecha, $seccion, $equipo, $pagina) {
        return new Response(sprintf(
            'Listado de noticias  en idioma=%s,
      fecha=%s,deporte=%s,equipo=%s, página=%s ',
            $_locale, $fecha, $seccion, $equipo, $pagina));
    }
    /**
     * @Route(
     *    "/deportes/{_locale}/{fecha}/{seccion}/{equipo}/{slug}.{_format}",
     *     defaults={"slug": "1","_format":"html"},
     *     requirements={
     *         "_locale": "es|en",
     *         "_format": "html|json|xml",
     *          "fecha": "[\d+]{8}"
     *     }
     * )
     */
    public function rutaAvanzada($_locale, $fecha, $seccion, $equipo, $slug) {
        // Simulamos una base de datos de deportes
                    $sports=["futbol","tenis","rugby"];
        // Simulamos una base de datos de equipos o personas
                    $teams=["valencia", "barcelona","federer", "rafa-nadal"];
        // Si el equipo o persona que buscamos no se encuentra redirigimos
        // al usuario a la página de inicio
        if(!in_array($equipo, $teams) || !in_array($seccion, $sports)) {
             return $this->redirectToRoute('lista_paginas');
        }
        return new Response(sprintf(
            'Mi noticia en idioma=%s,
      fecha=%s,deporte=%s,equipo=%s, noticia=%s ',
            $_locale, $fecha, $seccion, $equipo, $slug));
    }
    /**
     * @Route("/deportes/usuario", name="usuario" )
     */
    public function sesionUsuario(Request $request) {
        $usuario_get=$request->query->get('nombre');
        $session = $request->getSession();
        $session->set('nombre', $usuario_get);
        return $this->redirectToRoute('usuario_session',array('nombre'=>$usuario_get));
    }
    /**
     * @Route("/deportes/usuario/{nombre}", name="usuario_session" )
     */
    public function paginaUsuario() {
        $session=new Session();
        $usuario=$session->get('nombre');
        return new Response(sprintf('Sesión iniciada con el atributo nombre:%s', $usuario));
    }

    /**
     * @Route("/deportes/{slug}")
     */
    public function mostrar($slug)
    {
        return new Response(sprintf('Mi articulo en mi pagina de deportes: ruta %s',$slug));
    }

}
