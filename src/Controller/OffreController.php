<?php

namespace App\Controller;

use App\Entity\Offre;
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

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
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
     * @Route("/trier", name="offre_trie")
     */
    public function trier(OffreRepository $offreRepository,DistrictRepository $districtRepository, RegionRepository $regionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $offres=$offreRepository->findAll();
        if (isset($_POST['trie'])){
            if ($_POST['trie']=='DateCreation')
                $offres=$offreRepository->TrierParDateCreation();
            else if ($_POST['trie']=='disponibilite')
                $offres=$offreRepository->TrierParDisponibilite();
            else if ($_POST['trie']=='NomOffre')
                $offres=$offreRepository->TrierParNomOffre();
            else if ($_POST['trie']=='DateExpiration')
                $offres=$offreRepository->TrierParDateFin();
            else if ($_POST['trie']=='AgeMax')
                $offres=$offreRepository->TrierParAgeMax();
            else if ($_POST['trie']=='AgeMin')
                $offres=$offreRepository->TrierParAgeMin();
        }

        $offresFinales=[];
        foreach ($offres as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $pagination = $paginator->paginate(
            $offresFinales, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('offre/index.html.twig', [
            'offres' => $pagination,
        ]);
    }

    /**
     * @Route("/trierFront", name="offre_trie_front")
     */
    public function trierFront(OffreRepository $offreRepository,DistrictRepository $districtRepository, RegionRepository $regionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $offres=$offreRepository->findAll();
        if (isset($_POST['trie'])){
            if ($_POST['trie']=='DateCreation')
                $offres=$offreRepository->TrierParDateCreation();
            else if ($_POST['trie']=='disponibilite')
                $offres=$offreRepository->TrierParDisponibilite();
            else if ($_POST['trie']=='NomOffre')
                $offres=$offreRepository->TrierParNomOffre();
            else if ($_POST['trie']=='DateExpiration')
                $offres=$offreRepository->TrierParDateFin();
            else if ($_POST['trie']=='AgeMax')
                $offres=$offreRepository->TrierParAgeMax();
            else if ($_POST['trie']=='AgeMin')
                $offres=$offreRepository->TrierParAgeMin();
        }

        $offresFinales=[];
        foreach ($offres as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $pagination = $paginator->paginate(
            $offresFinales, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('offre/indexFront.html.twig', [
            'offres' => $pagination,
        ]);
    }

    /**
     * @Route("/search/",name="searchOffre")
     */
    public function search(Request $request){
        $requestString= $request->get('q');
        $posts=$this->repository->findLike($requestString);
        if (!$posts){
            $result['posts']['error'] = 'Aucun  trouvé';
        }
        else{
            $result['posts']=$this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    /**
     * @Route("/searchAll/",name="searchAllOffre")
     */
    public function searchAll(Request $request, DistrictRepository $districtRepository, RegionRepository $regionRepository, PaginatorInterface $paginator){
        $properties=$this->repository->findAllLike($_POST['mot']);
        if (!isset($_POST['mot']))
            $properties=$this->repository->findAll();

        $offresFinales=[];
        foreach ($properties as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $blogs = $paginator->paginate(
        // Doctrine Query, not results
            $offresFinales,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render("offre/index.html.twig",[
            "offres"=>$blogs
        ]);
    }

    /**
     * @Route("/searchAllFront/",name="searchAllOffreFront")
     */
    public function searchAllFront(Request $request, DistrictRepository $districtRepository, RegionRepository $regionRepository, PaginatorInterface $paginator){
        $properties=$this->repository->findAllLike($_POST['mot']);
        if (!isset($_POST['mot']))
            $properties=$this->repository->findAll();

        $offresFinales=[];
        foreach ($properties as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $blogs = $paginator->paginate(
        // Doctrine Query, not results
            $offresFinales,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render("offre/indexFront.html.twig",[
            "offres"=>$blogs
        ]);
    }


    public function getRealEntities($posts){
        foreach($posts as $post){
            $realEntities[$post->getNumoffre()] = [$post->getNomoffre()];

        }
        return $realEntities;
    }
    /**
     * @Route("/", name="offre_index", methods={"GET"})
     */
    public function index(OffreRepository $offreRepository, DistrictRepository $districtRepository, RegionRepository $regionRepository,  Request $request, PaginatorInterface $paginator): Response
    {
        $offres=$offreRepository->findAll();
        $offresFinales=[];
        foreach ($offres as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $pagination = $paginator->paginate(
            $offresFinales, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('offre/index.html.twig', [
            'offres' => $pagination
        ]);
    }

    /**
     * @param OffreRepository $offreRepository
     * @param DistrictRepository $districtRepository
     * @param RegionRepository $regionRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/front", name="offre_index_front", methods={"GET"})
     */
    public function indexFront(OffreRepository $offreRepository, DistrictRepository $districtRepository, RegionRepository $regionRepository,  Request $request, PaginatorInterface $paginator): Response
    {
        //pour l'affiche front
        $offres=$offreRepository->findAll();
        $offresFinales=[];

        foreach ($offres as $offre)
        {
            $district=$districtRepository->find($offre->getDistrict());
            $offresFinales[]=[

                'offre'=>$offre,
                'district'=>$district,
                'region'=>$regionRepository->find($district->getRegion())

            ];
        }
        $pagination = $paginator->paginate(
            $offresFinales, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('offre/indexFront.html.twig', [
            'offres' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="offre_new", methods={"GET","POST"})
     */
    public function new(Request $request, DistrictRepository $districtRepository): Response
    {
        $offre = new Offre();
        $districts = $districtRepository->findAll();
        $form = $this->createForm(Offre1Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $offre->setDistrict($_POST['district']);
            $entityManager->persist($offre);
            $entityManager->flush();
            $this->addFlash("info","Offre créée avec success");
            return $this->redirectToRoute('offre_index');
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'districts' => $districts,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{numoffre}", name="offre_show", methods={"GET"})
     */
    public function show(Offre $offre, DistrictRepository $districtRepository, RegionRepository $regionRepository): Response
    {
        $district = $districtRepository->find($offre->getDistrict());
        $region=$regionRepository->find($district->getRegion());
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
            'district' => $district,
            'region' => $region,
        ]);
    }

    /**
     * @Route("/{numoffre}/front", name="offre_show_front", methods={"GET"})
     */
    public function showFront(Offre $offre, DistrictRepository $districtRepository, RegionRepository $regionRepository): Response
    {
        $district = $districtRepository->find($offre->getDistrict());
        $region=$regionRepository->find($district->getRegion());
        return $this->render('offre/showFront.html.twig', [
            'offre' => $offre,
            'district' => $district,
            'region' => $region,
        ]);
    }

    /**
     * @Route("/pdf",name="offre_pdf", methods={"GET","POST"})
     */
    public function pdf(OffreRepository $offreRepository, DistrictRepository $districtRepository, RegionRepository $regionRepository,  Request $request, PaginatorInterface $paginator){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offre/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'nom'=>$_POST['nom'],
            'prenom'=>$_POST['prenom'],
            'age'=>$_POST['age'],
            'diplome'=>$_POST['diplome'],
            'email'=>$_POST['email'],
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
     * @Route("/{numoffre}/postuler", name="offre_postuler", methods={"GET"})
     */
    public function postuler(Offre $offre):Response
    {
        return $this->render('offre/formPostuler.html.twig', [
            'offre' => $offre
        ]);
    }

    /**
     * @Route("/{numoffre}/edit", name="offre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DistrictRepository $districtRepository, Offre $offre): Response
    {
        $form = $this->createForm(Offre1Type::class, $offre);
        $districts = $districtRepository->findAll();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("info","Offre modifiée avec success");
            return $this->redirectToRoute('offre_index');
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'districts' => $districts,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{numoffre}", name="offre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offre $offre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getNumoffre(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offre);
            $entityManager->flush();
            $this->addFlash("info","Offre supprimée avec success");
        }

        return $this->redirectToRoute('offre_index');
    }
} 
