<?php
/**
 * Created by PhpStorm.
 * User: trist
 * Date: 19/01/2019
 * Time: 11:17
 */

namespace App\Form;
use App\Entity\Employe;
use App\Entity\Metier;
use App\Repository\EmployeRepository;
use App\Repository\MetierRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EmployeType extends AbstractType
{
    private  $metierRepository;


    public function __construct(MetierRepository $metierRepository)
    {
        $this->metierRepository = $metierRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options){



        $builder
            ->add('Prenom', TextType::class, [
                'label' => 'Prenom',
            ])
            ->add('Nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email'
            ])
            /*
            ->add('Metier', 'entity', array(
                'class' => 'AcmeHelloBundle:User',
                'query_builder' => function (MetierRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC')
                        ->select('u.archive' == 'Non');
                },
            ))
            */
            ->add('Cout', NumberType::class, [
                'label' => 'Cout journalier'
            ])
            ->add('Embauche', DateType::class, [
                'label' => 'Date d\'embauche'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}