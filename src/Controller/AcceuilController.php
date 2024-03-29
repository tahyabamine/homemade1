<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name: 'acceuil_')]

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'acceuil')]
    public function index(AnnonceRepository $an, CategorieRepository $cat, SpecialiteRepository $spe): Response
    {
        $annonces = $an->findBy([], ['id'=>'DESC'],10 );
$categorie=$cat->findAll();
        return $this->render('acceuil/index.html.twig', [
            'annonces' => $annonces,
            'categories'=>$categorie,

        ]);
    }
}