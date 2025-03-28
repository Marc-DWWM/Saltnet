<?php

namespace App\Controller;

use App\Entity\Report;
use App\Form\ReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class ReportController extends AbstractController
{
    #[Route('/report', name: 'report')]
    public function report(Request $request, EntityManagerInterface $entityManager): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        


        if ($form->isSubmitted() && $form->isValid()) {
       
            $report->setUserReport($this->getUser());
            $report->setReportAt(new \DateTimeImmutable());

            $entityManager->persist($report);
            $entityManager->flush();
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

    
        return $this->render('report/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
