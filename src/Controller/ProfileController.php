<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(AnnonceRepository $an,  Request $request): Response
    {

        $limite = 1;
        $page = (int) $request->query->get('page', 1);
        $user = $this->getUser();
        $annonces = $an->getPaginatedAnnonce($page, $limite, $user);
        $total = $an->getAllAnnonces($user);

        return $this->render('profile/index.html.twig', [
            'annonce' => $annonces,
            'limite' => $limite,
            'page' => $page,
            'total' => $total

        ]);
    }

    /**
     * @Route("/profile/edit/{user}", name="app_editProfile")
     */
    public function update($user, UserRepository $er, Request $request)
    {

        $user = $er->find($user);

        $formulaire = $this->createForm(EditProfileType::class, $user);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->add($user);
            return $this->redirectToRoute('app_acceuil');
        } else {
            return $this->render('registration/edit.html.twig', [
                'form' => $formulaire->createView(),


            ]);
        }
    }
}