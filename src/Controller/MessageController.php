<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


final class MessageController extends AbstractController
{
    #[Route('/messages', name: 'messages')]
    public function message(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/send', name: 'send')]
    public function send(Request $request, EntityManagerInterface $em): Response
    {
        $message = new Message;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $message->setUserMessage($this->getUser());


            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }



        return $this->render('message/send.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
