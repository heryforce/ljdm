<?php

namespace App\Form;

use App\Entity\Plante;
use App\Entity\Luminosite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PlanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nomLatin')
            ->add('notes')
            ->add('arrosageStr', ChoiceType::class, [
                'choices' => [
                    'jour' => 'jour',
                    'semaine' => 'semaine',
                    'mois' => 'mois',
                ],
            ])
            ->add('arrosageNb', IntegerType:: class)
            ->add('nombre', IntegerType::class)
            ->add('bouturage')
            ->add('particularites', ChoiceType::class, [
                'choices' => [
                    'Dépolluante' => 'Dépolluante',
                    "Tombante" => 'Tombante',
                    "Fait des fleurs" => 'Fait des fleurs',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('luminosite', EntityType::class, [
                'class' => Luminosite::class,
                'choice_label' => 'libelle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plante::class,
        ]);
    }
}
