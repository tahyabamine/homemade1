<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesInformationsController extends AbstractController
{
    #[Route('/mes/informations', name: 'app_mes_informations')]
    public function show(): Response
    {
        

        return $this->render('mes_informations/index.html.twig', [

        ]);
    }
}
