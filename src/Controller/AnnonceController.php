<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\ImageRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IpValidator;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/create", name="create_annonce")
     */
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
                $an->add($annonce);
            }

            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('annonce/form.html.twig', [
            'form' => $formulaire->createView(),


        ]);
    }

    /**
     * @Route("/annonce/{annonce}", name="details")
     */
    public function details(Annonce $annonce)
    {

        return $this->render('annonce/details.html.twig', [
            'annonce' => $annonce,
        ]);
    }
    /**
     * @Route("/annonce/{id}/update", name="update")
     */
    public function update($id, AnnonceRepository $an, Request $request)
    {

        $annonce = $an->find($id);

        $formulaire = $this->createForm(AnnonceType::class, $annonce);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $an->add($annonce);
            return $this->redirectToRoute('app_profile');
        } else {
            return $this->render('annonce/form.html.twig', [
                'form' => $formulaire->createView(),
            ]);
        }
    }
    /**
     * @Route("/annonce/{id}/delete", name="delete")
     */
    public function delete($id, AnnonceRepository $an)
    {

        $annonce = $an->find($id);
        if (!$annonce) {
            throw $this->createNotFoundException(
                "L\'annonce n\'exist pas': " . $id
            );
        } else
            $an->remove($annonce);

        return $this->redirectToRoute('app_profile');
    }
}