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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class PlanteType extends AbstractType
{
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nomLatin')
            ->add('notes')
            ->add('arrosage')
            ->add('bouturage')
            ->add('particularites', ChoiceType::class, [
                'choices' => [
                    'Dépolluante' => 'Dépolluante',
                    "Tombante" => 'Tombante',
                    "Fleurs" => 'Fleurs',
                    "Fruits" => 'Fruits',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('luminosite', EntityType::class, [
                'class' => Luminosite::class,
                'choice_label' => 'libelle',
            ])
            ->add('maladies')
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $route = $this->request->get('_route');
                $form = $event->getForm();
                if ($route === 'main_proposition_plante') {
                    $form->add('userAffiche');
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plante::class,
        ]);
    }
}
