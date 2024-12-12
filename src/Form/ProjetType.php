<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idP', IntegerType::class, [
                'label' => 'ID Projet',
                'required' => true,
            ])
            ->add('nomP', TextType::class, [
                'label' => 'Nom du Projet',
                'required' => true,
            ])
            ->add('descriptionP', TextareaType::class, [
                'label' => 'Description du Projet',
                'required' => true,
            ])
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Début',
                'required' => true,
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Fin',
                'required' => true,
            ])
            ->add('statuts', TextType::class, [
                'label' => 'Statuts',
                'required' => true,
            ])
            ->add('pdfprojet', FileType::class, [
                'label' => 'Fichier PDF (optionnel)',
                'required' => false,
                'mapped' => false, // Prevent automatic mapping to the entity
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
