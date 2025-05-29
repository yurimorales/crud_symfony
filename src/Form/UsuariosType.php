<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use App\Entity\Usuarios;

class UsuariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'attr' => [
                    'required' => true,
                    'maxlength' => 255
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'required' => true,
                    'maxlength' => 100
                ]
            ])
            ->add('telefone', TextType::class, [
                'attr' => [
                    'required' => true,
                    'maxlength' => 14
                ]
            ])
            ->add('foto', FileType::class, [
                'label' => 'Foto',
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuarios::class,
        ]);
    }
}
