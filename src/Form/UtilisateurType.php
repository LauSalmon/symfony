<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le nom de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le prénom de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le mail de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le mot de passe de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
            ])
            ->add('urlImg', UrlType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le lien de l'image de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
