<?php

namespace App\Controller;

use App\Entity\Resultat;
use App\Form\ResultatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resultat")
 */
class ResultatController extends AbstractController
{
    /**
     * @Route("/", name="resultat_index", methods={"GET"})
     */
    public function index(): Response
    {
        $resultats = $this->getDoctrine()
            ->getRepository(Resultat::class)
            ->findAll();

        return $this->render('resultat/index.html.twig', [
            'resultats' => $resultats,
        ]);
    }

    /**
     * @Route("/new", name="resultat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resultat = new Resultat();
        $form = $this->createForm(ResultatType::class, $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resultat);
            $entityManager->flush();

            return $this->redirectToRoute('resultat_index');
        }

        return $this->render('resultat/new.html.twig', [
            'resultat' => $resultat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultat_show", methods={"GET"})
     */
    public function show(Resultat $resultat): Response
    {
        return $this->render('resultat/show.html.twig', [
            'resultat' => $resultat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resultat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resultat $resultat): Response
    {
        $form = $this->createForm(ResultatType::class, $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resultat_index');
        }

        return $this->render('resultat/edit.html.twig', [
            'resultat' => $resultat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultat_delete", methods={"POST"})
     */
    public function delete(Request $request, Resultat $resultat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resultat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resultat_index');
    }

    
}
