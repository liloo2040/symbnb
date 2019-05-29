<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $required = TRUE)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
            'required' => $required
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Ajouter un titre"))
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration("Adresse web", "Votre adresse web (automatique)", false)
            )
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image", "Ajoutez l'URL de votre image"))
            ->add(
                'introduction',
                TextType::class,
                $this->getConfiguration("Introduction", "Ajoutez une description à votre annonce")
            )
            ->add('content', TextareaType::class, $this->getConfiguration("Description détaillée", "Description annonce"))
            ->add(
                'rooms',
                IntegerType::class,
                $this->getConfiguration("Nombre de chambres", "Nombre de chambres disponibles")
            )
            ->add(
                'price',
                MoneyType::class,
                $this->getConfiguration("Prix par nuit", "Indiquez votre prix")
            )
            ->add(
                'images',
                CollectionType::class,
                array(
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
