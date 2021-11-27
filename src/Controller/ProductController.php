<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ProductSearch;
use App\Entity\Users;
use App\Form\CommandeType;
use App\Form\SearchForm;
use App\Repository\OffreRepository;
use App\Repository\PersonneRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ProductController extends AbstractController
{
    /**
     * @var OffreRepository
     */
    private $repository;

    public function __construct(ProduitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/productlist.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/detail", name="detail")
     */
    public function detail(): Response
    {
        return $this->render('product/detail.html.twig', [
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/addproduct", name="addproduct")
     */
    public function addproduct(Request $request, SessionInterface $session)
    {
        $product = new Produit();
        $form = $this->createForm(ProduitType::class, $product);
        $form->add('Ajouter', SubmitType::class, [
            'attr' => ['class' => 'button full-width margin-top-20'],]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();
            $file1 = $form->get('image1')->getData();
            $file2 = $form->get('image2')->getData();
            $file3 = $form->get('image3')->getData();
            $file4 = $form->get('image4')->getData();

            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $filename1 = md5(uniqid()) . '.' . $file1->guessExtension();
            $filename2 = md5(uniqid()) . '.' . $file2->guessExtension();
            $filename3 = md5(uniqid()) . '.' . $file3->guessExtension();
            $filename4 = md5(uniqid()) . '.' . $file4->guessExtension();

            $product->setImage($filename);
            $product->setImage1($filename1);
            $product->setImage2($filename2);
            $product->setImage3($filename3);
            $product->setImage4($filename4);

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // Move the file to the directory where brochures are stored
            try {
                $file1->move(
                    $this->getParameter('brochures_directory'),
                    $filename1
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // Move the file to the directory where brochures are stored
            try {
                $file2->move(
                    $this->getParameter('brochures_directory'),
                    $filename2
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // Move the file to the directory where brochures are stored
            try {
                $file3->move(
                    $this->getParameter('brochures_directory'),
                    $filename3
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // Move the file to the directory where brochures are stored
            try {
                $file4->move(
                    $this->getParameter('brochures_directory'),
                    $filename4
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product');
        }
        return $this->render('product/addproduct.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/product", name="product")
     */
    public function readproduct(PaginatorInterface $paginator, Request $request, SessionInterface $session)
    {

        $r = $this->getDoctrine()->getRepository(Produit::class);
        $products = $r->findAll();
        // Paginate the results of the query
        $products = $paginator->paginate(
        // Doctrine Query, not results
            $products,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        $session = $request->getSession();

        return $this->render('product/productlist.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    /******************affichage Json Produit*****************************************/

    /**
     * @Route("/displayProduct", name="displayProduct")
     */
    public function allprodAction()
    {

        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);

        return new JsonResponse($formatted);
    }


    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detailproduct($id): Response
    {
        $r = $this->getDoctrine()->getRepository(Produit::class);
        $product = $r->find($id);
        if (!$product) {
            return $this->redirectToRoute('product');
        }
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteproduct($id, ProduitRepository $repository)
    {
        $product = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("product");
    }

    /**
     * @Route("/deleteProduitJSON/{id}", name="deleteProduitJSON")
     */
    public function deleteProfileJSON(Request $request,NormalizerInterface $Normalizer,$id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(Produit::class)->find($id);
        $em->remove($produit);
        $em->flush();
        $jsonContent=$Normalizer->normalize($produit,'json',['groups'=>'post:read']);
        return new Response("Product deleted successfully".json_encode($jsonContent,JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/product/update/{id}", name="update")
     */
    public function update(ProduitRepository $repository, $id, Request $request)
    {
        $product = $repository->find($id);
        $form = $this->createForm(ProduitType::class, $product);
        $form->add('Modifier', SubmitType::class, [
            'attr' => ['class' => 'button full-width margin-top-20'],]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("product");
        }
        return $this->render('product/updateproduct.html.twig',
            [
                'f' => $form->createView()
            ]);
    }

    /******************Modifier Produit JSON*****************************************/

    /**
     * @Route("/updateProduitQuery", name="updateProduitQuery")
     */
    public function updateProduitQuery(Request $request)
    {
        #http://127.0.0.1:8000/updateProduitQuery?id=83&titre=test&description=test&image=test
        $produit = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->find($request->query->get("id"));

        $nom = $request->query->get("nom");
        $description = $request->query->get("description");
        $prix = $request->query->get("prix");
        $fournisseur = $request->query->get("fournisseur");
        $image = $request->query->get("image");
        $image1 = $request->query->get("image1");
        $image2 = $request->query->get("image2");
        $image3 = $request->query->get("image3");
        $image4 = $request->query->get("image4");

        $em = $this->getDoctrine()->getManager();

        $produit->setNom($nom);
        $produit->setDescription($description);
        $produit->setPrix($prix);
        $produit->setFournisseur($fournisseur);
        $produit->setImage($image);
        $produit->setImage($image1);
        $produit->setImage($image2);
        $produit->setImage($image3);
        $produit->setImage($image4);

        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit,'json',['groups'=>'post:read']);
        return new JsonResponse($formatted);

    }

    /******************Ajouter Produit JSON*****************************************/

    /**
     * @Route("/addProduitJSON", name="addProduitJSON")
     */
    public function addProduitJSON(Request $request,NormalizerInterface $Normalizer): Response
    {
        $produit=new Produit();
        $produit->setNom($request->get('nom'));
        $produit->setDescription($request->get('description'));
        $produit->setPrix($request->get('prix'));
        $produit->setFournisseur($request->get('fournisseur'));
        $produit->setImage($request->get('image'));
        $produit->setImage1($request->get('image1'));
        $produit->setImage2($request->get('image2'));
        $produit->setImage3($request->get('image3'));
        $produit->setImage4($request->get('image4'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();

        $jsonContent=$Normalizer->normalize($produit,'json',['groups'=>'post:read']);
        return new Response("Produit added successfully".json_encode($jsonContent,JSON_UNESCAPED_UNICODE));
    }


    /**
     * @Route("/product/search", name="search")
     */
    public function recherche(ProduitRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $data = $request->get('search');
        $products = $repository->findBy(['nom' => $data]);

        // Paginate the results of the query
        $products = $paginator->paginate(
        // Doctrine Query, not results
            $products,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        if ($data == '') {
            $this->addFlash(
                'info',
                'Pas de produits'
            );
        }
        return $this->render('product/productlist.html.twig',
            [
                'controller_name' => 'ProductController',
                'products' => $products,
            ]);
    }


    /**
     * @Route("/product/trier", name="trier")
     */
    public function trier(ProduitRepository $produitRepository, Request $request, PaginatorInterface $paginator)
    {
        $products = $produitRepository->findAll();
        if (isset($_POST['trie'])) {
            if ($_POST['trie'] == 'moins') {
                $products = $produitRepository->TriMin();
            }
            if ($_POST['trie'] == 'plus') {
                $products = $produitRepository->TriMax();
            }
        }
        // Paginate the results of the query
        $products = $paginator->paginate(
        // Doctrine Query, not results
            $products,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            100
        );
        return $this->render('product/productlist.html.twig',
            [
                'controller_name' => 'ProductController',
                'products' => $products,
            ]);
    }


    /**
     * @Route("/searchproduct/",name="searchproduct")
     */
    public function search(Request $request)
    {
        $requestString = $request->get('q');
        $posts = $this->repository->findByString($requestString);
        if (!$posts) {
            $result['posts']['error'] = 'Aucun  trouvé';
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }

    public function getRealEntities($posts)
    {
        foreach ($posts as $post) {
            $realEntities[$post->getNom()] = [$post->getImage(), $post->getId(), $post->getNom()];
        }
        return $realEntities;
    }


}