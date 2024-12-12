<?php

namespace App\Form;

use App\Entity\EtudiantExamen;
use App\Entity\Examen;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroEtudiant')
            ->add('note')
            ->add('etudiant', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('examen', EntityType::class, [
                'class' => Examen::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtudiantExamen::class,
        ]);
    }
}
