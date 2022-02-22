<?php

namespace App\Form;

use App\Entity\Articulo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ArticuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('fecha')
            ->add('texto')
            ->add('comentario')
            ->add('resumen')
            ->add('categoria', ChoiceType::class, [
                'choices' => [
                    'Opinión' => 'opinion',
                    'Divulgación' => 'divulgacion',
                    'Informativo' => 'informativo',
                    'Reportaje' => 'reportaje',
                    'Editorial' => 'editorial',
                    'Columna' => 'columna',
                    'Entrevista' => 'entrevista',
                    'Crítica' => 'critica',
                    'Otros' => 'otros'
                ]
            ])
            ->add('url')
            ->add('medio', ChoiceType::class, [
                'choices' => [
                    'Papel' => 'papel',
                    'Digital' => 'digital'
                ]
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articulo::class,
        ]);
    }
}
