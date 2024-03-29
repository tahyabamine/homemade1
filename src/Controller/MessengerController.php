<?php

namespace App\Controller;

use App\Entity\Messenger;
use App\Form\MessengerType;
use App\Repository\MessengerRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('messenge', name: 'messenger_')]

class MessengerController extends AbstractController
{
    #[Route('/', name: 'messenger')]
    public function index(): Response
    {
        return $this->render('messenger/index.html.twig');
    }

    #[Route('/send/{id}', name: 'send')]
    #[IsGranted('ROLE_USER')]
    public function send($id, UserRepository $user, Request $request): Response
    {
        $message = new Messenger;
        $form = $this->createForm(MessengerType::class, $message);
        $recepteur = $user->find($id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setEnvoyeur($this->getUser());
            $envoyeur=$message->getEnvoyeur();
            $message->setRecepteur($recepteur);
            $r=$id;
            $e=$envoyeur->getId();
            if ($e==$r){
            $this->addFlash("error", "you cant send a message to your count.");
            return $this->redirectToRoute("profile_profile");
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
                $this->addFlash("success", "Message envoyé avec succès.");
                return $this->redirectToRoute("profile_profile");
            }
        }

        return $this->render("messenger/index.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/received', name: 'received')]
    public function received(): Response
    {
        return $this->render('messenger/received.html.twig');
    }

    #[Route('/sent', name: 'sent')]
    public function sent(): Response
    {
        return $this->render('messeneger/sent.html.twig');
    }

    #[Route('/read/{id}', name: 'read')]
    public function read(Messenger $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('messenger/read.html.twig', compact("message"));
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, MessengerRepository $messenger): Response
    {
   $message=$messenger->find($id);
        $messenger->remove($message);
        return $this->redirectToRoute("messenger_received");
    }
}
