<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobile", name="mobile")
     */
    public function index(): Response
    {
        return $this->render('mobile/index.html.twig', [
            'controller_name' => 'MobileController',
        ]);
    }

    /**
     * @Route ("/AllQuiz", name="AllQuiz")
     */


    public function getQuiz (NormalizerInterface $serializer)
    {
        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();
        $json=$serializer->normalize($quizzes, 'json', ['groups'=>'post:read']);
       // return $this->render('quiz/allQuizJSON.html.twig',['data'=>$json]);
        return new Response(json_encode($json));
    }



    /**
     * @Route("/new", name= "quiz_new_mobile", methods={"GET","POST"})
     */

    public  function  addQuiz(Request $request, NormalizerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $quizzes= new Quiz();
        $quizzes->setTitle($request->get('title'));
        $em->persist($quizzes);
        $em->flush();
        $json=$serializer->normalize($quizzes, 'json', ['groups'=>'post:read']);

        return new Response("Information added successfully".json_encode($json));


    }
    /**
     * @Route("/deleteQuiz", name= "quiz_delete_mobile", methods={"GET","POST"})
     */
    public function delete_quiz (Request $request, NormalizerInterface $serializer)
    {
        $em=$this->getDoctrine()->getManager();
        $quizzes = $em->getRepository(Quiz::class)->find($request->get('id'));
        $em->remove($quizzes);
        $em->flush();
        $json=$serializer->normalize($quizzes, 'json', ['groups'=>'post:read']);
        return new Response("Information deleted successfully".json_encode($json));
    }
    /**
     * @Route("/updateQuiz", name= "quiz_update_mobile", methods={"GET","POST"})
     */
    public function update_quiz (Request $request ,NormalizerInterface $serializer )
    {
        $em=$this->getDoctrine()->getManager();
        $quizzes = $em->getRepository(Quiz::class)->find($request->get('id'));
        $quizzes->setTitle($request->get('title'));
        $em->flush();
        $json=$serializer->normalize($quizzes, 'json', ['groups'=>'post:read']);
        return new Response("Information updated successfully".json_encode($json));
    }
    /**
     * @Route ("/AllQuestion", name="AllQuestion", methods={"GET"})
     */
    public function getQuestion (Request $request,NormalizerInterface $serializer)
    {
        $quiz=$request->get('idquiz');
        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(['quiz'=>$quiz]);
        $json=$serializer->normalize($question, 'json', ['groups'=>'post:read']);
        // return $this->render('quiz/allQuizJSON.html.twig',['data'=>$json]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/newQuestion", name= "Question_new_mobile", methods={"GET","POST"})
     */

    public  function  addQuestion(Request $request, NormalizerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $question= new Question();
        $quizz= new Quiz();
        if($request->get('ajout')==1)
        {
            $quizz->setTitle($request->get('title'));
            $em->persist($quizz);
            $em->flush();
        }

        //$quizzes = $em->getRepository(Quiz::class)->findOneBy(['title'=>$request->get('title')]);
        $quizzes = $em->getRepository(Quiz::class)->findBy(['title'=>$request->get('title')],['quizid'=>'DESC'],1);
        $question->setQuestion($request->get('question'));
        $question->setOption1($request->get('option1'));
        $question->setOption2($request->get('option2'));
        $question->setOption3($request->get('option3'));
        $question->setOption4($request->get('option4'));
        $question->setAnswer($request->get('answer'));
        foreach ($quizzes as $quiz) {
            $question->setQuiz($quiz->getQuizid());
        }

            $em->persist($question);
            $em->flush();
            $json = $serializer->normalize($question, 'json', ['groups' => 'post:read']);
            $json = $serializer->normalize($quizz, 'json', ['groups' => 'post:read']);

            return new Response("Information added successfully" . json_encode($json));


    }
    /**
     * @Route("/deleteQuestion", name= "question_delete_mobile", methods={"GET","POST"})
     */
    public function delete_question (Request $request, NormalizerInterface $serializer)
    {
        $em=$this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)->find($request->get('id'));
        $em->remove($question);
        $em->flush();
        $json=$serializer->normalize($question, 'json', ['groups'=>'post:read']);
        return new Response("Information deleted successfully".json_encode($json));
    }
    /**
     * @Route("/updateQuestion", name= "question_update_mobile", methods={"GET","POST"})
     */
    public function update_question (Request $request ,NormalizerInterface $serializer )
    {
        $em=$this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)->find($request->get('id'));
        $question->setQuestion($request->get('question'));
        $question->setOption1($request->get('option1'));
        $question->setOption2($request->get('option2'));
        $question->setOption3($request->get('option3'));
        $question->setOption4($request->get('option4'));
        $question->setAnswer($request->get('answer'));
        $em->flush();
        $json=$serializer->normalize($question, 'json', ['groups'=>'post:read']);
        return new Response("Information updated successfully".json_encode($json));
    }
    /**
     * @Route("/contact", name="contact")
     */

    public function mailing( EntityManagerInterface  $em ,Request $request, \Swift_Mailer $mailer)
    {
        
        $message = (new \Swift_Message('Hello Email'));
        if($request->get('model')=="ajoutQuiz"){
            $message->setFrom('officiumtarentula@gmail.com')
            ->setTo('officiumtarentula@gmail.com')
            //->setObject("Mon nouveau quiz")
            ->setBody("Quiz ajouté avec succes");
    }
    else if($request->get('model')=="ajoutQuestion"){
        $message->setFrom('officiumtarentula@gmail.com')
        ->setTo('officiumtarentula@gmail.com')
        //->setObject("Mon nouveau quiz")
        ->setBody("Question ajouté avec succes dans le quiz ".$request->get('title'));}
        
    $mailer->send($message);
    return new Response(null);

    }
    
}
