<?php
namespace App\Form;

use App\Entity\Tache;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idT', TextType::class)
            ->add('nomT', TextType::class)
            ->add('descriptionT', TextType::class)
            ->add('dateDebut', DateTimeType::class)
            ->add('dateFin', DateTimeType::class)
            ->add('statusT', TextType::class)
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nomP',  // Utilisation de la propriété nomP de Projet
                'placeholder' => 'Sélectionner un projet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,  // Assurez-vous que Tache::class est bien défini
        ]);
    }
}