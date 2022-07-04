<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\IpValidator;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('annonce', name: 'annonce_')]
class AnnonceController extends AbstractController
{
    #[Route('/create', name: 'create')]
    #[IsGranted('ROLE_USER')]
    public function creatAnnonce(Request $request, AnnonceRepository $an): Response
    {
        $annonce = new Annonce;

        $formulaire = $this->createForm(AnnonceType::class, $annonce);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $annonce->setUser($this->getUser());
            $images = $formulaire->get('images')->getData(); // $image = une instance de UploadedFile
            $ok = true;
            foreach ($images as $image) {
                $newName = uniqid() . '.' . $image->guessExtension(); // Je crée un nouveau nom
                try {
                    // Je déplace l'image vers sa nouvelle destination
                    $image->move(
                        $this->getParameter('imagesDirectory'), // Le dossier de destination
                        $newName // Le nom du fichier à sa nouvelle destination
                    );
                    $img = new Image;
                    $img->setImg($newName);
                    $annonce->addImage($img);
                } catch (Exception $e) {
                    $this->addFlash('errors', 'Un problème est survenu pendant l\'upload du fichier.');
                    $ok = false;
                }
            }

            if ($ok) {
                $annonce->addCategorie($formulaire->get('categorie')->getData());
                $an->add($annonce);
            }

            return $this->redirectToRoute('acceuil_acceuil');
        }

        return $this->render('annonce/form.html.twig', [
            'form' => $formulaire->createView(),
        ]);
    }

    #[Route('/{annonce}', name: 'details')]
    public function details(Annonce $annonce)
    {
        return $this->render('annonce/details.html.twig', [
            'annonce' => $annonce,
          
        ]);
    }

    #[Route('/update/{annonce}', name: 'update')]
    public function update($annonce, AnnonceRepository $an, Request $request)
    {
        $annonce = $an->find($annonce);
        $formulaire = $this->createForm(AnnonceType::class, $annonce);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $images = $formulaire->get('images')->getData(); // $image = une instance de UploadedFile
            $ok = true;
            foreach ($images as $image) {
                $newName = uniqid() . '.' . $image->guessExtension(); // Je crée un nouveau nom
                try {
                    // Je déplace l'image vers sa nouvelle destination
                    $image->move(
                        $this->getParameter('imagesDirectory'), // Le dossier de destination
                        $newName // Le nom du fichier à sa nouvelle destination
                    );
                    $img = new Image;
                    $img->setImg($newName);
                    $annonce->addImage($img);
                } catch (Exception $e) {
                    $this->addFlash('errors', 'Un problème est survenu pendant l\'upload du fichier.');
                    $ok = false;
                }
            }

            if ($ok) {
                $annonce->addCategorie($formulaire->get('categorie')->getData());
                $an->add($annonce);
            }

            return $this->redirectToRoute('profile_profile');
        } else {
            return $this->render('annonce/form.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }
    #[Route('/supprimer/{annonce}', name: 'supprimer')]
    public function supprimer($annonce, AnnonceRepository $an)
    {
        $annonce = $an->find($annonce);
        if (!$annonce) {
            throw $this->createNotFoundException(
                "L\'annonce n\'exist pas'"
            );
        } else
            $an->remove($annonce);

        return $this->redirectToRoute('profile_profile');
    }

    #[Route('/favoris/ajout/{id}/{user}', name: 'ajout_favoris')]
    public function ajoutFavoris($user,Annonce $annonce, UserRepository $us)
    {
        if (!$annonce) {
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $annonce->addFavori($this->getUser());
$user=$us->find($user);
        $user->addFavori($annonce);
        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();  
         $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('acceuil_acceuil');
    }

    #[Route('/favoris/retrait/{id}/{user}', name: 'retrait_favoris')]
    public function retraitFavoris($user,Annonce $annonce, UserRepository $us)
    {
        if (!$annonce) {
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $annonce->removeFavori($this->getUser());
        $user=$us->find($user);
        $user->removeFavori($annonce);

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return $this->redirectToRoute('acceuil_acceuil');
    }

    #[Route('/annonce-details/{annonce}', name: 'detailsAnnonce')]
    public function detailsAnnonce(Annonce $annonce,Request $request)
    {// Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Commentaire;

        // On génère le formulaire
        $commentForm = $this->createForm(CommentaireType::class, $comment);

        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setAnnonce($annonce);
            $comment->setUser($this->getUser());
            // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if($parentid != null){
                $parent = $em->getRepository(Commentaire::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('annonce_detailsAnnonce',['annonce' => $annonce->getId()]);
        }
        return $this->render('annonce/detailsAnnonces.html.twig', [
            'annonce' => $annonce,
            'form'=>$commentForm->createView()
        ]);
    }
}
