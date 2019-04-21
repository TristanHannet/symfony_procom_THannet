<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Form\EmployeType;
use App\Entity\Employe;
use App\Repository\MetierRepository;
use App\Repository\EmployeRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/employe", name="employe_")
 */
class EmployeController extends AbstractController
{
    private  $metierRepository;
    private  $employeRepository;
    private  $projetRepository;

    public function __construct(EmployeRepository $employeRepository, ProjetRepository $projetRepository, MetierRepository $metierRepository)
    {
        $this->employeRepository = $employeRepository;
        $this->projetRepository = $projetRepository;
        $this->metierRepository = $metierRepository;
    }



    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {
        $res=$paginator->paginate($this->employeRepository->findAll(),$request->query->getInt('page', 1), 10);
        return $this->render('employe/list.html.twig', [
            'employes' => $res
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifier(int $id)
    {
        $employe = $this->employeRepository->find($id);

        return $this->render('employe/form.html.twig', [
                'employe' => $employe,
            'metiers' => $this->metierRepository->findBy(['archive' => 'Non']),
            ]);
    }

    /**
     * @Route("/creer", name="creer")
     */
    public function creer(Request $request)
    {

        $employe = new Employe;
        $form = $this->createForm(EmployeType::class,$employe);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Cet employe a bien été ajouté');



            $em = $this->getDoctrine()->getManager();


            $em->persist($employe);

            $em->flush();


            return $this->redirectToRoute('employe_list');
        }

        return $this->render('employe/creer.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/detail/{id}", name="detail", requirements={"id" = "\d+"})
     */
    public function detail(int $id)
    {
        $employe = $this->employeRepository->find($id);



        return $this->render('employe/detail.html.twig', [
            'employe' => $employe,
            'projets' => $this->projetRepository->findAll()
        ]);


    }


    /**
     * @Route("/sup/{id}", name="sup")
     */
    public function supprimer(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $employe = $em->getRepository(Employe::class)->find($id);

        $employe -> setArchive("Oui");

        $em->flush();

        return $this->redirectToRoute('employe_list');
    }
}