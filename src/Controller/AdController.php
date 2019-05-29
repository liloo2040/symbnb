<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * Crée une annonce
     * @Route("/ads/new", name="ads_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée!");

            return $this->redirectToRoute('ads_show', array(
                'slug' => $ad->getSlug()
            ));
        }
        return $this->render(
            'ad/new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Affichage du formulaire d'édition
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrées !");

            return $this->redirectToRoute('ads_show', array(
                'slug' => $ad->getSlug()
            ));
        }
        return $this->render('ad/edit.html.twig', array(
            'form' => $form->createView(),
            'ad' => $ad
        ));
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
