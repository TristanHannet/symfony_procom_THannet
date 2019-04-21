<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Entity\Metier;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTimeInterface;
class AppFixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->manager = $manager;
        $this->loadMetier();
        $this->loadProjets();

        $this->loadEmployes();
    }

    private function loadProjets ()
    {
        for ($i = 1; $i < 15; $i++){
            if($i % 2 != 0){
                $projet = (new Projet())
                    ->setIntitule('Projet '.$i)
                    ->setDescription('Projet de description '.$i)
                    ->setCreation(\DateTime::createFromFormat("d/m/Y H:i","25/04/2015 15:00"))
                    ->setType("Capex")
                    ->setLivre("NON");

            }
            else{
                $projet = (new Projet())
                    ->setIntitule('Projet '.$i)
                    ->setDescription('Projet de description '.$i)
                    ->setCreation(\DateTime::createFromFormat("d/m/Y H:i","25/04/2015 15:00"))
                    ->setType("Opex")
                    ->setLivre("NON");
            }



            $this->manager->persist($projet);
        }
        $this->manager->flush();
    }



    private function loadMetier()
    {
        $metierName = [
            'Dev F',
            'Designer',
            'SEO',
            'Dev B',
        ];

        foreach ($metierName as $key => $metierName) {
            $metier = (new Metier())
                ->setNom($metierName)
                ->setArchive("Non");

            $this->manager->persist($metier);
            $this->addReference('metier'.$key, $metier);
        }

        $this->manager->flush();
    }


    private function loadEmployes()
    {
        for ($i = 1; $i < 15; $i++){
            if($i != 12) {
                $employe = (new Employe())
                    ->setNom('Nom ' . $i)
                    ->setPrenom('Prenom ' . $i)
                    ->setEmbauche(\DateTime::createFromFormat("d/m/Y H:i", "25/04/2015 15:00"))
                    ->setCout(200.00)
                    ->setEmail("employe" . $i . "@gmail.com")
                    ->setMetier($this->getReference('metier'.random_int(0, 3)))
                    ->setArchive("Non");
            }
            else{
                $employe = (new Employe())
                    ->setNom('Nom ' . $i)
                    ->setPrenom('Prenom ' . $i)
                    ->setEmbauche(\DateTime::createFromFormat("d/m/Y H:i", "25/04/2015 15:00"))
                    ->setCout(2000.00)
                    ->setEmail("employe" . $i . "@gmail.com")
                    ->setMetier($this->getReference('metier'.random_int(0, 3)))
                    ->setArchive("Oui");


            }




            $this->manager->persist($employe);
        }
        $this->manager->flush();
    }
}
