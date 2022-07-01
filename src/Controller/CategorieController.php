<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('categorie', name: 'categorie_')]
class CategorieController extends AbstractController
{
    #[Route('/{categorie}', name: 'categorie')]
    public function index($categorie,CategorieRepository $ca): Response
    {
        $cat=$ca->find($categorie);

        return $this->render('categorie/index.html.twig', [
            'categorie'=>$cat,

        ]);
    }
}
