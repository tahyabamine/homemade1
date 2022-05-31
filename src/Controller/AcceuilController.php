<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="app_acceuil")
     */
    public function index(AnnonceRepository $an): Response
    {
        $annonces = $an->findAll();

        return $this->render('acceuil/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}