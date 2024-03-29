<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('contact', name: 'contact_')]
class ContactController extends AbstractController
{

    #[Route('/formulaire', name: 'contactUs')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $data = $formulaire->getData();
            // J'envoie mon mail
            $email = new Email();
            $email->from($data['email'])
            ->to('contact@tahya-abdessalam.com')
            ->subject($data['sujet'])
            ->text($data['message']);
            $mailer->send($email);
            $this->addFlash('success', 'Vore message a été envoyé');
            return $this->redirectToRoute('acceuil_acceuil');
        } else {
            return $this->render('contact/index.html.twig', [
                'form' => $formulaire->createView()
            ]);
        }
    }
}
