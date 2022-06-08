<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $data = $formulaire->getData();

            // J'envoie mon mail
            $email = new Email();
            $email->from('tahya.bamine@outlook.fr')
                ->to($data['email'])
                ->subject($data['sujet'])
                ->text($data['message']);
            $mailer->send($email);

            $this->addFlash('success', 'Vore message a été envoyé');

            return $this->redirectToRoute('app_acceuil');
        } else {
            return $this->render('contact/index.html.twig', [
                'form' => $formulaire->createView()
            ]);
        }
    }
}