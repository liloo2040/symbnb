<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\AdType;

class AdController extends Controller
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {

        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Créé une annonce
     * @Route("/ads/new", name="ads_create")
     *
     * @return Response
     */
    public function create()
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        return $this->render(
            'ad/new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */
    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig', array(
            'ad' => $ad
        ));
    }
}
