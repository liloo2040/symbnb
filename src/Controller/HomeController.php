<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/bonjour/{prenom}/age/{age}", name="hello")
     * @Route("/salut", name="hello_base")
     * @Route("/bonjour/{prenom}", name="hello_prenom")
     * Montre la route
     */
    public function hello($prenom = 'anonyme', $age = 0)
    {
        return $this->render(
            'hello.html.twig',
            array(
                'prenom' => $prenom,
                'age' => $age
            )
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $prenoms = array('Lior' => 31, 'Joseph' => 12, 'Anne' => 55);
        return $this->render(
            'home.html.twig',
            array(
                'title' => 'Hello World !',
                'age' => 12,
                'tableau' => $prenoms
            )
        );
    }
}
