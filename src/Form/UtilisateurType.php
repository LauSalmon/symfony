<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
                //si on veux que la valeur ne sois obligatoire
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le prénom de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le mail de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les 2 mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ])
            ->add('urlImg', UrlType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le lien de l'image de l'utilisateur :",
                'label_attr' => ["class" => 'label_input'],
                //si on veux que la valeur ne sois pas obligatoire
                'required' => false
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
