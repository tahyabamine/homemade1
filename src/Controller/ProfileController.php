<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddAdresseType;
use App\Form\EditProfileType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManager;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(AnnonceRepository $an,  Request $request): Response
    {

        $limite = 4;
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
     * @Route("/profile/info", name="app_info")
     */
    public function info(UserRepository $er): Response
    {
;
        return $this->render('profile/mesinfos.html.twig');
    }
    /**
     * @Route("/profile/annonces", name="app_profile_annonces")
     */
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
    #[Route('/profile/ajout/{user}', name: 'app_ajoutAdresse')]
    public function addAdresse($user, UserRepository $er, Request $request)
    {
        $user = $er->find($user);

        $formulaire = $this->createForm(AddAdresseType::class, $user);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $er->add($user);
            return $this->redirectToRoute('app_profile');
        } else {
            return $this->render('adresse/ajouter.html.twig', [
                'form' => $formulaire->createView(),


            ]);
        }
    }
    /**
     * @Route("/profile/adresse", name="gererAdresse")
     */
    public function gereAdresse()
    {
        return $this->render('profile/gererAdresse.html.twig');
    }
       /**
     * @Route("/profile/changePassword", name="changePassword")
     */
    public function changePassword(UserRepository $er,EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator, string $token = null, Request $request):Response
    {

 $us=$this->getUser();
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

            return $this->redirectToRoute('app_profile');
    }
    return $this->render('reset_password/reset.html.twig', [
        'resetForm' => $form->createView(),
    ]);
}
    /**
     * @Route("/profile/delete", name="delete_user")
     */
    public function deleteUser(EntityManagerInterface $em): Response
    {

        $user=$this->getUser();
        $this->container->get('security.token_storage')->setToken(null);
        
        $em->remove($user);
        $em->flush();
        
        // Ceci ne fonctionne pas avec la création d'une nouvelle session !
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !'); 

        return $this->redirectToRoute('app_acceuil');
    }
}
