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
        // $limite = 2;
        // $page = (int) $request->query->get('page', 1);
        // $annonces = $annoncesRepo->pagination($page, $limite);
        // $total = $annoncesRepo->tousLesAnnonces();
        $annonces= $annoncesRepo->findAll();
        $form = $this->createForm(SearchAnnonceType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recherche les annonces correspondant aux mots clés
            $annonces = $annoncesRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
            );
            dd($annonces);
        }
        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
            // 'total' => $total,
            // 'limite' => $limite,
            // 'page' => $page,
        ]);
    }
}
