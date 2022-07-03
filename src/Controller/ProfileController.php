<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditImageType;
use App\Form\AddAdresseType;
use App\Form\SpecialiteType;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManager;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use App\Repository\AnnonceRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Service\ResetInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

#[Route('profile', name: 'profile_')]

class ProfileController extends AbstractController
{
    #[Route('/', name: 'profile')]
    public function index(AnnonceRepository $an,  Request $request, UserRepository $use): Response
    {
        $us = $this->getUser();
        $user = $use->find($us);
        $limite = 4;
        $page = (int) $request->query->get('page', 1);
        $annonces = $an->getPaginatedAnnonce($page, $limite, $user);
        $total = $an->getAllAnnonces($user);
        $specialite = $user->getSpecialite();
        return $this->render('profile/index.html.twig', [
            'annonce' => $annonces,
            'limite' => $limite,
            'page' => $page,
            'total' => $total,
            'specalite' => $specialite

        ]);
    }

    #[Route('/info', name: 'info')]
    public function info(UserRepository $er): Response
    {
        return $this->render('profile/mesinfos.html.twig');
    }

    #[Route('/annonces', name: 'annonces')]
    public function annonces(AnnonceRepository $an,  Request $request): Response
    {
        $limite = 4;
        $page = (int) $request->query->get('page', 1);
        $user = $this->getUser();
        $annonces = $an->getPaginatedAnnonce($page, $limite, $user);
        $total = $an->getAllAnnonces($user);
        return $this->render('profile/annonces.html.twig', [
            'annonce' => $annonces,
            'limite' => $limite,
            'page' => $page,
            'total' => $total

        ]);
    }

    #[Route('/edit/{user}', name: 'edit')]
    public function update($user, UserRepository $er, Request $request)
    {
        $user = $er->find($user);
        $formulaire = $this->createForm(EditProfileType::class, $user);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->add($user);
            return $this->redirectToRoute('profile_profile');
        } else {
            return $this->render('registration/edit.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }

    #[Route('/ajouter-adresse/{user}', name: 'ajoutAdresse')]
    public function addAdresse($user, UserRepository $er, Request $request)
    {
        $user = $er->find($user);
        $formulaire = $this->createForm(AddAdresseType::class, $user);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->setRegion($formulaire->get('region')->getData());
            $er->add($user);
            return $this->redirectToRoute('profile_profile');
        } else {
            return $this->render('adresse/ajouter.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }
    #[Route('/update-adresse/{user}', name: 'updateAdresse')]
    public function updateAdresse($user, UserRepository $er, Request $request)
    {
        $user = $er->find($user);
        $formulaire = $this->createForm(AddAdresseType::class, $user);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->add($user);
            return $this->redirectToRoute('profile_profile');
        } else {
            return $this->render('adresse/ajouter.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }

    #[Route('/adresse', name: 'gerermonadresse')]
    public function gereAdresse()
    {
        return $this->render('profile/gererAdresse.html.twig');
    }

    #[Route('/change-password', name: 'changePassword')]
    public function changePassword(UserRepository $er, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator, string $token = null, Request $request): Response
    {
        $us = $this->getUser();
        $user = $er->find($us);
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($encodedPassword);
            $entityManager->flush();
            // The session is cleaned up after the password has been changed.
            // $this->cleanSessionAfterReset();
            return $this->redirectToRoute('profile_profile');
        }
        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    #[Route('/delete', name: 'deleteUser')]
    public function deleteUser(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $em->remove($user);
        $em->flush();
        $session = new Session();
        $session->invalidate();
        // Ceci ne fonctionne pas avec la création d'une nouvelle session !
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');
        return $this->redirectToRoute('acceuil_acceuil');
    }

    #[Route('/ajout-spacialite/{user}', name: 'ajoutSpecialite')]
    public function ajouspecialite($user, UserRepository $er, Request $request, SpecialiteRepository $spec)
    {
        $user = $er->find($user);
        $formulaire = $this->createForm(SpecialiteType::class, $user);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->add($user);
            return $this->redirectToRoute('profile_profile');
        } else {
            return $this->render('profile/ajouspecialite.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }

    #[Route('/edit-avatar/{user}', name: 'editAvatar')]
    public function updateAvatar($user, UserRepository $er, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $er->find($user);
        $formulaire = $this->createForm(EditImageType::class, $user);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $avatar = $formulaire->get('avatar')->getData(); // $image = une instance de UploadedFile
            $ok = true;
            if ($avatar) {
                $newName = uniqid() . '.' . $avatar->guessExtension(); // Je crée un nouveau nom
                try {
                    // Je déplace l'image vers sa nouvelle destination
                    $avatar->move(
                        $this->getParameter('avatarDirectory'), // Le dossier de destination
                        $newName // Le nom du fichier à sa nouvelle destination
                    );
                    $user->setAvatar($newName);
                } catch (Exception $e) {
                    $this->addFlash('errors', 'Un problème est survenu pendant l\'upload du fichier.');
                    $ok = false;
                }
            }
            if ($ok) {
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('profile_profile');
            }
        } else {
            return $this->render('registration/edit.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }

    #[Route('/mes-favoris', name: 'mesFavoris')]
    public function mesFavoris()
    {
        return $this->render('profile/favoris.html.twig');
    }
}
