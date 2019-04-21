<?php

namespace App\Controller;

use App\Form\MetierType;
use App\Entity\Metier;
use App\Repository\EmployeRepository;
use App\Repository\MetierRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
/**
 * @Route("/metier", name="metier_")
 */
class MetierController extends AbstractController
{

    private  $metierRepository;


    public function __construct(MetierRepository $metierRepository)
    {
        $this->metierRepository = $metierRepository;

    }



    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {

        $res=$paginator->paginate($this->metierRepository->findBy(['archive' => 'Non']),$request->query->getInt('page', 1), 10);
        return $this->render('metier/list.html.twig', [
            'metiers' => $res,
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifier(int $id, Request $request)
    {
        //$metier = $this->metierRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $metier = $em->getRepository(Metier::class)->find($id);
        $form = $this->createForm(MetierType::class,$metier);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Le métier a bien été ajouté');






            $em->persist($metier);

            $em->flush();


            return $this->redirectToRoute('metier_list');
        }

        return $this->render('metier/form.html.twig', [
                'form' => $form->createView(),
                'metier' => $metier,
            ]);
    }

    /**
     * @Route("/sup/{id}", name="sup")
     */
    public function supprimer(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $metier = $em->getRepository(Metier::class)->find($id);

        $metier -> setArchive("Oui");

        $em->flush();

        return $this->redirectToRoute('metier_list');
    }

    /**
     * @Route("/creer", name="creer")
     */
    public function creer(Request $request)
    {

        $metier = (new Metier)->setArchive("Non");
        $form = $this->createForm(MetierType::class,$metier);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Le métier a bien été ajouté');



            $em = $this->getDoctrine()->getManager();


            $em->persist($metier);

            $em->flush();


            return $this->redirectToRoute('metier_list');
        }

        return $this->render('metier/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }



}