<?php

namespace App\Controller;

use App\Form\SearchAnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(AnnonceRepository $annoncesRepo, Request $request): Response
    {
        $annonces = $annoncesRepo->findBy([], ['id' => 'desc']);

        $form = $this->createForm(SearchAnnonceType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recherche les annonces correspondant aux mots clés
            $annonces = $annoncesRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
            );
        }

        return $this->render('recherche/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView()
        ]);
    }
}
