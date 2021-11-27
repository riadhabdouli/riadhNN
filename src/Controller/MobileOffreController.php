<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Offre;
use App\Entity\Region;
use App\Form\Offre1Type;
use App\Repository\DistrictRepository;
use App\Repository\OffreRepository;
use App\Repository\RegionRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class
MobileOffreController extends AbstractController
{

    /**
     * @var OffreRepository
     */
    private $repository;

    public  function __construct(OffreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/mobile", name="mobile")
     */
    public function index(): Response
    {
        return $this->render('mobile/index.html.twig', [
            'controller_name' => 'MobileOffreController',
        ]);
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("/AllOffre", name="AllOffre", methods={"GET"})
     */
    public function AllOffre(Request $request, PaginatorInterface $paginator, NormalizerInterface $normalizer): Response
    {

        $of = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();
        $jsonContent = $normalizer->normalize($of, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/IDOffre/{id}", name="IDOffre")
     */
    public function OffreID(Request $request, $id, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $of = $em->getRepository(Offre::class)->find($id);
        $jsonContent = $normalizer->normalize($of, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addOffreJSON/new", name="addOffreJSON")
     */
    public function addOffreJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $of = new Offre();
        $creation = $request->get('creation');
        $expiration = $request->get('expiration');
        $datecreation = \DateTime::createFromFormat('Y-m-j', "$creation");
        $dateexpiration = \DateTime::createFromFormat('Y-m-j', "$expiration");
        $of->setDisponibilite($request->get('disponibilite'));
        $of->setNomoffre($request->get('nomoffre'));
        $of->setExperience($request->get('experience'));
        $of->setNiveauEtude($request->get('niveauEtude'));
        $of->setSexe($request->get('sexe'));
        $of->setAgemin($request->get('agemin'));
        $of->setAgemax($request->get('agemax'));
        $of->setSecteur($request->get('secteur'));
        $of->setDescription($request->get('description'));
        $of->setDistrict($request->get('district'));
        $of->setDateCreation($datecreation);
        $of->setDateExpiration($dateexpiration);
        $em->persist($of);
        $em->flush();
        $jsonContent = $normalizer->normalize($of, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updateOffreJSON", name="updateOffreJSON")
     */
    public function updateoffreJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $of = $em->getRepository(Offre::class)->find($request->get('id'));
        $creation = $request->get('creation');
        $expiration = $request->get('expiration');
        dd($creation);
        $datecreation = \DateTime::createFromFormat('Y-M-D', "$crea");
        $dateexpiration = \DateTime::createFromFormat('Y-M-D', "$expiration");
        $of->setDisponibilite($request->get('disponibilite'));
        $of->setNomoffre($request->get('nomoffre'));
        $of->setExperience($request->get('experience'));
        $of->setNiveauEtude($request->get('niveauEtude'));
        $of->setSexe($request->get('sexe'));
        $of->setAgemin($request->get('agemin'));
        $of->setAgemax($request->get('agemax'));
        $of->setSecteur($request->get('secteur'));
        $of->setDescription($request->get('description'));
        $of->setDistrict($request->get('district'));
        $of->setDateCreation($datecreation);
        $of->setDateExpiration($dateexpiration);
        $em->flush();
        $jsonContent = $normalizer->normalize($of, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }

    /**
     * @Route("/AllRegion", name="AllRegion", methods={"GET"})
     */
    public function AllRegion(Request $request, PaginatorInterface $paginator, NormalizerInterface $normalizer): Response
    {

        $reg = $this->getDoctrine()
            ->getRepository(Region::class)
            ->findAll();
        $jsonContent = $normalizer->normalize($reg, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/IDRegion/{id}", name="IDRegion")
     */
    public function RegionID(Request $request, $id, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reg = $em->getRepository(Region::class)->find($id);
        $jsonContent = $normalizer->normalize($reg, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addRegionJSON", name="addRegionJSON")
     */
    public function addRegionJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reg = new Region();

        $reg->setNomRegion($request->get('nomregion'));

        $em->persist($reg);
        $em->flush();
        $jsonContent = $normalizer->normalize($reg, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updateRegionJSON", name="updateRegionJSON")
     */
    public function updateregionJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reg = $em->getRepository(Region::class)->find($request->get('id'));
        $reg->setNomRegion($request->get('nomregion'));
        $em->flush();
        $jsonContent = $normalizer->normalize($reg, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }

    /**
     * @Route("/AllDistrict", name="AllDistrict", methods={"GET"})
     */
    public function AllDistrict(Request $request, PaginatorInterface $paginator, NormalizerInterface $normalizer): Response
    {

        $dis = $this->getDoctrine()
            ->getRepository(District::class)
            ->findAll();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/IDDistrict/{id}", name="IDDistrict")
     */
    public function DistrictID(Request $request, $id, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = $em->getRepository(District::class)->find($id);
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addDistrictJSON/new", name="addDistrictJSON")
     */
    public function addDistrictSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = new District();
        $dis->setNomDistrict($request->get('nomdistrict'));
        $dis->setRegion($request->get('region'));

        $em->persist($dis);
        $em->flush();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deleteDistrictJSON", name="deleteDistrictJSON")
     */
    public function deleteDistrictJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = $em->getRepository(District::class)->find($request->get('id'));
        $em->remove($dis);
        $em->flush();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }
    /**
     * @Route("/deleteRegionJSON", name="deleteRegionJSON")
     */
    public function deleteRegionJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = $em->getRepository(Region::class)->find($request->get('id'));
        $em->remove($dis);
        $em->flush();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }
    /**
     * @Route("/deleteOffreJSON", name="deleteOffreJSON")
     */
    public function deleteOffreJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = $em->getRepository(Offre::class)->find($request->get('id'));
        $em->remove($dis);
        $em->flush();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }

    /**
     * @Route("/updateDistrictJSON", name="updateDistrictJSON")
     */
    public function updateDistrictJSON(Request $request, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $dis = $em->getRepository(District::class)->find($request->get('id'));
        $dis->setNomDistrict($request->get('nomdistrict'));
        $dis->setRegion($request->get('setregion'));
        $em->flush();
        $jsonContent = $normalizer->normalize($dis, 'json', ['groups' => 'post:read']);

        return new Response("Information updated successfully" . json_encode($jsonContent));
    }

    /**
     * @Route("/mailOffre", name="maillingOffre")
     */
    public function mailOffre(Request $request, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Gestion des Offres'))
            ->setFrom('reinemekontchou116@gmail.com')
            ->setTo('reinemekontchou116@gmail.com');
        if ($request->get('type') == "ajout") {
            $message->setBody("Offre ajoutée avec succès");
        } elseif ($request->get('type') == "supprimer")
            $message->setBody("Offre supprimée avec succès");
        elseif ($request->get('type') == "modifier")
            $message->setBody("Offre modifiée avec succès");
        $mailer->send($message);

        return new Response(null);
    }

    /**
     * @Route("/mailDistrict", name="mailDistrict")
     */
    public function mailDistrict(Request $request, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Gestion des Districts'))
            ->setFrom('reinemekontchou116@gmail.com')
            ->setTo('reinemekontchou116@gmail.com');
        if ($request->get('type') == "ajout") {
            $message->setBody("District ajouté avec succès");
        } elseif ($request->get('type') == "supprimer")
            $message->setBody("District supprimé avec succès");
        elseif ($request->get('type') == "modifier")
            $message->setBody("District modifié avec succès");
        $mailer->send($message);

        return new Response(null);
    }

    /**
     * @Route("/mailRegion", name="mailRegion")
     */
    public function mailRegion(Request $request, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Gestion des Regions'))
            ->setFrom('reinemekontchou116@gmail.com')
            ->setTo('reinemekontchou116@gmail.com');
        if ($request->get('type') == "ajout") {
            $message->setBody("Region ajoutée avec succès");
        } elseif ($request->get('type') == "supprimer")
            $message->setBody("Region supprimée avec succès");
        elseif ($request->get('type') == "modifier")
            $message->setBody("Region modifiée avec succès");
        $mailer->send($message);

        return new Response(null);
    }

    /**
     * @Route("/Offrepdf",name="offrepdf", methods={"GET","POST"})
     */
    public function pdf(OffreRepository $offreRepository, DistrictRepository $districtRepository, RegionRepository $regionRepository,  Request $request, PaginatorInterface $paginator){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offre/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'nom'=>$request->get('nom') ,
            'prenom'=>$request->get('prenom') ,
            'age'=>$request->get('age') ,
            'diplome'=>$request->get('diplome') ,
            'email'=>$request->get('mail') ,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/searchAllOffreMobile/",name="searchAllOffreMobile")
     */
    public function searchAllOffre(Request $request, NormalizerInterface $normalizer){
        $properties=$this->repository->findAllLike($request->get('mot'));

        $jsonContent = $normalizer->normalize($properties, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));

    }

}
