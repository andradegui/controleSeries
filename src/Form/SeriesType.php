<?php

namespace App\Form;

use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\DTO\SeriesCreateFormInput;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('seriesName', options: ['label' => 'Nome Série:'])
                ->add('seasonsQuantity', NumberType::class, options: ['label' => 'Qtd. Temporadas:'])
                ->add('episodesPerSeason', NumberType::class, options: ['label' => 'Ep. por Temporada'])
                ->add('save', SubmitType::class, ['label' => $options['flag_edit'] ? 'Editar' : 'Adicionar'])
                ->setMethod($options['flag_edit'] ? 'PATCH' : 'POST')
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeriesCreateFormInput::class,
            'flag_edit' => false,
        ]);

        $resolver->setAllowedTypes('flag_edit', 'bool');
    }
}
