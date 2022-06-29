<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name: 'acceuil')]

class AcceuilController extends AbstractController
{
    #[Route('/', name: '/acceuil')]
    public function index(AnnonceRepository $an, CategorieRepository $cat, SpecialiteRepository $spe): Response
    {
        $annonces = $an->findAll();
$categorie=$cat->findAll();
$specialites=$spe->findBy([], ['id'=>'DESC'],10 );
        return $this->render('acceuil/index.html.twig', [
            'annonces' => $annonces,
            'categories'=>$categorie,

        ]);
    }
}