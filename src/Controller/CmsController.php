<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MetierRepository;
use App\Repository\EmployeRepository;
use App\Repository\ProjetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/", name="cms_")
 */
class CmsController extends AbstractController
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
     * @Route("", name="homepage")
     */
    public function home()
    {
        $projetEnCours = $this->projetRepository->ProjetEnCours();
        $projetTermine = $this->projetRepository->ProjetTermine();
        $nbEmploye = $this->employeRepository->NbEmploye();
        $taux_livr1 = $this->projetRepository->TauxLivre1();
        $taux_livr2 = $this->projetRepository->TauxLivre2();
        $taux_livr = $taux_livr1/$taux_livr2;

        return $this->render('cms/index.html.twig', [
            'controller_name' => 'CmsController',
            'projetEnCours' => $projetEnCours,
            'projetTermine' => $projetTermine,
            'nbEmploye' => $nbEmploye,
            'projets' => $this->projetRepository->findAll(),
            'taux_livre' => round($taux_livr),
        ]);
    }


}