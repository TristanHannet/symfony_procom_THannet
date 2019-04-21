<?php

namespace App\Controller;

use App\Form\ProjetType;
use App\Entity\Projet;
use App\Repository\EmployeRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
/**
 * @Route("/projet", name="projet_")
 */
class ProjetController extends AbstractController
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $contactEmailAddress;


    private  $employeRepository;
    private  $projetRepository;

    public function __construct(\Swift_Mailer $mailer,EmployeRepository $employeRepository, ProjetRepository $projetRepository)
    {
        $this->employeRepository = $employeRepository;
        $this->projetRepository = $projetRepository;
        $this->mailer = $mailer;

    }

    /**
     * @Route("/livre/{id}", name="livre")
     */
    public function livre(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $projet = $em->getRepository(Projet::class)->find($id);

        $projet -> setLivre("OUI");

        $em->flush();

        return $this->redirectToRoute('projet_list');
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {

        $res=$paginator->paginate($this->projetRepository->findAll(),$request->query->getInt('page', 1), 10);
        return $this->render('projet/list.html.twig', [
            'projets' => $res
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifier(int $id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);

        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Le projet a été Modifié!');





            $em->persist($projet);

            $em->flush();


            return $this->redirectToRoute('projet_list');
        }

        return $this->render('projet/form.html.twig', [
                'projet' => $projet,
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/creer", name="creer")
     */
    public function creer(Request $request)
    {

        $projet = (new Projet)
            ->setLivre("NON")
            ->setCreation(new \DateTime('now'));
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Le projet a été ajouté!');


            $em = $this->getDoctrine()->getManager();


            $em->persist($projet);

            $em->flush();


            return $this->redirectToRoute('projet_list');
        }


        return $this->render('projet/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail", requirements={"id" = "\d+"})
     */
    public function detail(int $id)
    {
        $projet= $this->projetRepository->find($id);



        return $this->render('projet/detail.html.twig', [
            'projet' => $projet,
            'employes' => $this->employeRepository->findBy(['archive' => 'Non'])
        ]);


    }


    /**
     * @Route("/sup/{id}", name="sup")
     */
    public function supprimer(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $projet = $em->getRepository(Projet::class)->find($id);

        $message = (new \Swift_Message('Rapport Suppression Projet'))
            ->setFrom('sender@test.com')
            ->setTo('Adresse.test@gmail.com')
            ->setBody(
                $this->renderView('email/contact.html.twig', ['projet' => $projet]),
                'text/html'
            );

        $this->mailer->send($message);

        $em->remove($projet);
        $em->flush();

        return $this->redirectToRoute('projet_list');
    }


    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request,  PaginatorInterface $paginator)
    {
        $queryString = $request->query->get('search');
        $data = $this->projetRepository->Search($queryString);
        $res=$paginator->paginate($data,$request->query->getInt('page', 1), 10);

        return $this->render('projet/list.html.twig', [
            'projets' => $res
        ]);
    }

}