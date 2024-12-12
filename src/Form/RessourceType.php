<?php

// src/Form/RessourceType.php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeR', ChoiceType::class, [
                'choices' => [
                    'TD' => 'TD',
                    'TP' => 'TP',
                    'Cour' => 'Cour',
                ],
                'label' => 'Type de ressource',
            ])
            ->add('nomR', TextType::class, [
                'label' => 'Nom de la ressource',
            ])
            ->add('fileR', TextareaType::class, [
                'label' => 'Description du fichier',
            ])
            ->add('dureeR', ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                ],
                'label' => 'Durée (en heures)',
            ])
            ->add('pdfressource', FileType::class, [
                'label' => 'Télécharger un PDF',
                'required' => false, // facultatif si vous ne voulez pas obliger l'utilisateur à uploader un fichier
                'mapped' => false, // Ce champ n'est pas mappé directement à une propriété de l'entité
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}

