<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
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