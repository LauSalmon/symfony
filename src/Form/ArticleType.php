<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le titre de l'article :",
                'label_attr' => ["class" => 'label_input'],
                //si on veux que la valeur ne sois obligatoire
                'required' => true
            ])
            ->add('contenu', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le contenu de l'article :",
                'label_attr' => ["class" => 'label_input'],
                //si on veux que la valeur ne sois obligatoire
                'required' => true
            ])
            ->add('dateCreation', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input'
                ],
                'label' => 'Saisir la date de creation :',
                'label_attr' => ["class" => 'label_input'],
                //si on veux que la valeur ne sois obligatoire
                'required' => true
            ])
            ->add('urlImg', UrlType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le lien de l'image de l'article :",
                'label_attr' => ["class" => 'label_input'],
                //si on veux que la valeur ne sois pas obligatoire
                'required' => false
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'expanded' => false,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
