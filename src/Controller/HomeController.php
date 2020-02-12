<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AdRepository;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function home(AdRepository $adRepo, UserRepository $userRepo)
    {
        return $this->render(
            'home.html.twig',
            array(
                'ads' => $adRepo->findBestAds(3),
                'users' => $userRepo->findBestUsers(2)
            )
        );
    }
}
