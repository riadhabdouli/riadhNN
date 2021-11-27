<?php

namespace App\Controller;

use App\Entity\Entretien;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionEntretienQuizController extends AbstractController
{
    /**
     * @Route("/gestion/entretien/quiz", name="gestion_entretien_quiz")
     */
    public function index(): Response
    {
        return $this->render('gestion_entretien_quiz/index.html.twig', [
            'controller_name' => 'GestionEntretienQuizController',
        ]);
    }

    /**
     * @Route("/affichage", name="entretien_affichage", methods={"GET"})
     */
    public function affiche()
    {
        $entretiens = $this->getDoctrine()
            ->getRepository(Entretien::class)
            ->findAll();

        return new Response($this->render('entretien/afficheFront.html.twig', [
            'entretiens' => $entretiens,
        ]));
    }
}
