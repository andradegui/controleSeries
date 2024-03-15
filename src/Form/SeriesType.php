<?php

namespace App\Form;

use App\Entity\Series;
use App\DTO\SeriesCreateFormInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('seriesName', options: ['label' => 'Nome Série:'])
                ->add('seasonsQuantity', NumberType::class, options: ['label' => 'Qtd. Temporadas:'])
                ->add('episodesPerSeason', NumberType::class, options: ['label' => 'Ep. por Temporada'])
                ->add('save', SubmitType::class, ['label' => 'Adicionar'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeriesCreateFormInput::class,            
        ]);

    }
}
