<?php

namespace App\Form;

use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('name', options: ['label' => 'Nome Série:'])
            ->add('save', SubmitType::class, ['label' => $options['flag_edit'] ? 'Editar' : 'Adicionar'])
            ->setMethod($options['flag_edit'] ? 'PATCH' : 'POST');
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
            'flag_edit' => false,
        ]);

        $resolver->setAllowedTypes('flag_edit', 'bool');
    }
}
