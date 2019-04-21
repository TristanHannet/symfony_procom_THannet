<?php
/**
 * Created by PhpStorm.
 * User: trist
 * Date: 19/01/2019
 * Time: 11:17
 */

namespace App\Form;
use App\Entity\Projet;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('Intitule', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('Type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Capex' => 'Capex',
                    'Opex' => 'Opex',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}