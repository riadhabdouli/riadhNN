<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Resultat;
use App\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * @Route("/quiz")
 */
class QuizController extends AbstractController
{

    /**
     * @Route("/", name="quiz_index", methods={"GET"})
     */
    public function index(): Response
    {
        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);

    }

    /**
     * @Route("/QuizListFront", name="quizListFront", methods={"GET"})
     */
    public function indexFront(): Response
    {
        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();
        return $this->render('quiz/liste.html.twig', [
            'quizzes' => $quizzes,
        ]);

    }


    /**
     * @Route("/new", name= "quiz_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{quizid}", name="quiz_show", methods={"GET"})
     */
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * @Route("/{quizid}/edit", name="quiz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{quizid}", name="quiz_delete", methods={"POST"})
     */
    public function delete(Request $request, Quiz $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getQuizid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quiz_index');
    }
    /*public function traitement_quizz($id, Request $request , QuizzRepository $quizzRepository, EntityManagerInterface $em)
    {
        $score=0;
        $quizz=$quizzRepository->find($id);
        $total=count($quizz->getQuestions());
        $params=$request->request->all();//recuperer les reponses DE L'UTILISATEUR
        foreach ( $quizz->getQuestions() as $key=>$question){
            if(key_exists($question->getId(),$params))
            {
                if(intval($params[$question->getId()])==$question->getCorrectAnswer()->getId())
                {

                        $score++;
                }
            }

        }
        $score=(($score*100)/$total);
        $user=$em->getRepository(Personne::class)->findOneBy(['id'=>1]);
          $quizz->setScore($score);
          $quizz->setUser($user);


          if ($score>70 )
          {
              $type=array('Distanciel', 'Présentiel');
              $entretien=new Entretien();
              $entreprise= $em->getRepository(Entreprise::class)->findOneBy(['id'=>1]);
              $entretien->setUser($user);
              //$entretien->getTitle();
              //$entretien->getOffre($offre)->getDateCreation();
              $entretien->setHeure(new \DateTime());
              $entretien->setDate(new \DateTime());
              $entretien->setEntreprise($entreprise);
              $entretien->setType($type[random_int(0,1)]);
              $entretien->setTitle('Mon entretien');
              $em->persist($entretien);
              $em->flush();
              $quizz->setEntretien($entretien);

          }
        $em->persist($quizz);
        $em->flush();
        //dd($quizz);
        //die();
        return $this->render('quizz/traitement.html.twig',['quizz'=>$quizz]);
    }*/

    /**
     * @Route("/getQuiz/{idquiz}", name="getQuiz", methods={"GET"})
     */
    public function getQuiz($idquiz): Response
    {
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(['quiz'=>$idquiz]);

        return $this->render('quiz/affichage.html.twig', [
            'questions' => $questions,
            'idquiz' => $idquiz,
        ]);
    }

    /**
     * @Route("/traitement/{idquiz}", name="traitementQuiz", methods={"GET","POST"})
     */
    public function traitementQuiz($idquiz): Response
    {
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(['quiz'=>$idquiz]);
        $score=0;
        $nbrquestions=0;
        foreach($questions as $question){
        $nbrquestions++;
            if($_POST[$question->getQuestionId()]==$question->getAnswer())
                $score++;
        }
        $resultat=new Resultat();
        $resultat->setQuizid($idquiz);
        $resultat->setUserid(1);
        $resultat->setNote($score.' sur '.$nbrquestions);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($resultat);
        $entityManager->flush();
        return $this->indexFront();
    }



}
