<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Entity\Quiz;
use App\Entity\Resultat;
use App\Form\EntretienType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entretien")
 */
class EntretienController extends AbstractController
{
    /**
     * @Route("/", name="entretien_index", methods={"GET"})
     */
    public function index(): Response
    {
        $entretiens = $this->getDoctrine()
            ->getRepository(Entretien::class)
            ->findAll();

        return $this->render('entretien/index.html.twig', [
            'entretiens' => $entretiens,
        ]);
    }

    /**
     * @Route("/new", name="entretien_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entretien);
            $entityManager->flush();

            return $this->redirectToRoute('entretien_index');
        }

        return $this->render('entretien/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entretien_show", methods={"GET"})
     */
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    
    
    
    /**
     * @Route("/addEntretien/{id}/{type}/{note}", name="entretien_add", methods={"GET"})
     */
    public function ajoutentretien($type,$id,$note,Request $request, \Swift_Mailer $mailer){
        $em = $this->getDoctrine()->getManager();
        $type=array('Distanciel', 'Présentiel');
        $entretien=new Entretien();
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($id);
              $entretien->setUserId(1);
              $entretien->setTitle("Entretien suite au quiz ");
              $entretien->setHeure(new \DateTime());
              $entretien->setDate(new \DateTime());
              $entretien->setEntrepriseId(1);
              $entretien->setType($type[random_int(0,1)]);
              $entretien->setEndAt(new \DateTime());
              $entretien->setBeginAt(new \DateTime());
              $entretien->setQuizzId($id);
              $em->persist($entretien);
              $em->flush();
              $this->mailing("accepter",$id,$note,$request,$mailer);
              return $this->index();
    }

    public function mailing($type,$id,$note,Request $request, \Swift_Mailer $mailer)
    {
        
        $message = (new \Swift_Message('Résultat du quiz'));
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($id);
            if($type=="modifier"){
                $message->setFrom('officiumtarentula@gmail.com')
                ->setTo('officiumtarentula@gmail.com')
                //->setObject("Mon nouveau quiz")
                ->setBody("Des modifications ont été effectuées concernant l'entretien suite au quiz ".$quiz->getTitle().". Veuillez les consulter dans l'option Voir Entretiens");
        }
        
        else if($type=="accepter"){
            $message->setFrom('officiumtarentula@gmail.com')
            ->setTo('officiumtarentula@gmail.com')
            //->setObject("Mon nouveau quiz")
            ->setBody("Félicitations ! Vous avez réussi avec brio le Quiz ".$quiz->getTitle()." avec une note de ".$note.". Vous recevrez les détails de votre entretien dans votre compte.");
    }
    else if($type=="refuser"){
        $message->setFrom('officiumtarentula@gmail.com')
        ->setTo('officiumtarentula@gmail.com')
        //->setObject("Mon nouveau quiz")
        ->setBody("Vous avez malheureusement échoué à votre quiz. Vous n'obtiendrez pas d'entretien. ".$request->get('title'));}
        
    $mailer->send($message);

    }

    /**
     * @Route("/{id}/edit", name="entretien_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entretien $entretien): Response
    {
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entretien_index');
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entretien_delete", methods={"POST"})
     */
    public function delete(Request $request, Entretien $entretien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entretien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entretien_index');
    }
     /**
     * @Route("/refusEntretien/{id}/{idresultat}/{type}/{note}", name="resultat_refus", methods={"GET","POST"})
     */
    public function deleteEntretien($type,$id,$idresultat,$note,Request $request, \Swift_Mailer $mailer): Response
    {
        $resultat=$this->getDoctrine()
        ->getRepository(Resultat::class)
        ->find($idresultat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resultat);
            $entityManager->flush();
            $this->mailing("refuser",$id,$note,$request,$mailer);
        

        return $this->redirectToRoute('resultat_index');
    }
}
