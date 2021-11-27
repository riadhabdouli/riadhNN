<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Profil;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class PersonneController extends AbstractController
{
    /**
     * @Route("/personne1", name="personne1")
     */
    public function index1(): Response
    {
        return $this->render('personne/index1.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }

    /**
     * @return Response
     * @Route("/personne", name="personne")
     */
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }


    /**
     * @param PersonneRepository $repo
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route("/personneAffiche", name="personneAffiche")
     */
    public function liste(PersonneRepository $repo,NormalizerInterface $normalizer)
    {
        $personne = $repo->findAll();
        $jsonContent=$normalizer->normalize($personne,'json',['groups'=>'post:read']);
        //var_dump($jsonContent);
        return $this->render('personne/Affiche.html.twig', [
            'data' => $personne
        ]);
    }

    /**
     * @param PersonneRepository $repo
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route("/personneAfficheJSON", name="personneAfficheJSON")
     */
    public function listeJSON(PersonneRepository $repo,NormalizerInterface $normalizer)
    {
        $personne = $repo->findAll();
        $jsonContent=$normalizer->normalize($personne,'json',['groups'=>'post:read']);
        return  new Response(json_encode($jsonContent));
    }

    /**
     * @param $id
     * @param PersonneRepository $repository
     * @return Response
     * @Route ("/AffichePerso/{id}", name="AffichePerso")
     */
    public function affichePerso($id, PersonneRepository $repository)
    {
        $personne = $repository->find($id);
        return $this->render('personne/AffichePerso.html.twig', [
            'p' => $personne
        ]);
    }

    /**
     * @param $id
     * @param PersonneRepository $repository
     * @return RedirectResponse
     * @Route ("/personneSupprime/{id}", name="s")
     */
    public function Supprimer($id, PersonneRepository $repository)
    {
        $personne = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute('personneAffiche');
    }


    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Route("/personneAjoute",name="personneAjoute")
     */
    function Ajouter(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $perso=new Personne();
        $profil=new Profil();
        $profil->setPersonne($perso);
        $form= $this->createForm(PersonneType::class,$perso);
        $form->add("Valider",SubmitType::class);//boutton formulaire
//le bouton avant le gestionnaire de requetes
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $hash=$encoder->encodePassword($perso,$perso->getPassword());
            $perso->setPassword($hash);
            $em->persist($perso);
            $em->flush();
            $profil->setId($perso->getId());
            $em->persist($profil);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render("personne/Ajouter.html.twig", [
            //'username' => $perso->getUsername(),
            "form"=>$form->createView()
        ]);
    }

    /**
     * @param $id
     * @param PersonneRepository $repository
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/personneUpdate/{id}", name="personneUpdate")
     */
    public function Udpdate($id, PersonneRepository $repository,Request $request)
    {
        $perso = $repository->find($id);
        $form=$this->createForm(PersonneType::class,$perso);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('personneAffiche');
        }
        return $this->render('personne/Update.html.twig',[

            'form'=>$form->createView() ]);
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @param PersonneRepository $rep
     * @return Response
     * @throws ExceptionInterface
     * @Route("/searchPersonnex ", name="searchPersonnex")
     */
    public function searchPersonnex(Request $request,NormalizerInterface $normalizer,PersonneRepository $rep)
    {
        $requestString =  $request->get('searchValue');
        $personne = $rep->findPersonneByNom($requestString);
        $jsonContent = $normalizer->normalize($personne, 'json',['groups'=>'post:read']);
        $retour= json_encode($jsonContent);
        return new Response($retour);
    }

    /**
     * @param $id
     * @param NormalizerInterface $normalizer
     * @param PersonneRepository $rep
     * @return Response
     * @throws ExceptionInterface
     * @Route("/search{id} ", name="search")
     */
    public function search($id,NormalizerInterface $normalizer,PersonneRepository $rep)
    {
        //findPersonneByNom
        $personne = $rep->find($id);
        $jsonContent = $normalizer->normalize($personne, 'json',['groups'=>'post:read']);
        $retour= json_encode($jsonContent);
        return new Response($retour);
    }

    /**
     * @param $nom
     * @param NormalizerInterface $normalizer
     * @param PersonneRepository $rep
     * @return Response
     * @throws ExceptionInterface
     * @Route("/personneJSON/{nom} ", name="personneJSON")
     */
    public function personneJSON($nom,NormalizerInterface $normalizer,PersonneRepository $rep)
    {
        //findPersonneByNom
        $personne = $rep->findPersonneByNom($nom);
        $jsonContent = $normalizer->normalize($personne, 'json',['groups'=>'post:read']);
        $retour= json_encode($jsonContent);
        return new Response($retour);
    }


    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route("/login1", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('personne/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @return Response
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }

    /**
     * @param $id
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws ExceptionInterface
     * @Route("updatePersonneJSON/{id}", name="updatePersonneJSON")
     */
    public function updatePersonneJSON($id,Request $request,NormalizerInterface $normalizer,UserPasswordEncoderInterface $encoder)
    {
        $em=$this->getDoctrine()->getManager();
        $personne=$em->getRepository(Personne::class)->find($id);
        $personne->setSexe($request->get('sexe'));
        $personne->setAge($request->get('age'));
        $personne->setEmail($request->get('email'));
        $personne->setTelephone($request->get('telephone'));
        $personne->setNom($request->get('nom'));
        $personne->setPrenom($request->get('prenom'));
        $personne->setPassword($request->get('password'));
        $hash=$encoder->encodePassword($personne,$personne->getPassword());
        $personne->setPassword($hash);
        $em->flush();
        $jsonContent=$normalizer->normalize($personne,'json',['groups'=>'post:read']);
        return  new Response("modification reussie".json_encode($jsonContent));
    }

    /**
     * @param $id
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route("deletePersonneJSON/{id}", name="deletePersonneJSON")
     */
    public function deletePersonneJSON($id,NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $personne=$em->getRepository(Personne::class)->find($id);
        $profil=$em->getRepository(Profil::class)->find($id);
        $em->remove($profil);
        $em->remove($personne);
        $em->flush();
        $jsonContent=$normalizer->normalize($personne,'json',['groups'=>'post:read']);
        return  new Response(json_encode($jsonContent));
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws ExceptionInterface
     * @Route("addPersonneJSON/new", name="addPersonneJSON")
     */
    public function addPersonneJSON(Request $request,NormalizerInterface $normalizer,UserPasswordEncoderInterface $encoder)
    {
        $em=$this->getDoctrine()->getManager();
        $personne=new Personne();
        $profil=new Profil();
        $personne->setSexe($request->get('sexe'));
        $personne->setAge($request->get('age'));
        $personne->setEmail($request->get('email'));
        $personne->setTelephone($request->get('telephone'));
        $personne->setNom($request->get('nom'));
        $personne->setPrenom($request->get('prenom'));
        $personne->setPassword($request->get('password'));
        $hash=$encoder->encodePassword($personne,$personne->getPassword());
        $personne->setPassword($hash);
        $em->persist($personne);
        $em->flush();
        $profil->setId($personne->getId());
        //$profil->setPersonne($personne->getId());
        $profil->setPersonne($personne);
        $em->persist($profil);
        $em->flush();
        $jsonContent=$normalizer->normalize($personne,'json',['groups'=>'post:read']);
        return  new Response(json_encode($jsonContent));
    }






}
