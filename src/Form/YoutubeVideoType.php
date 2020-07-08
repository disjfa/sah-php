<?php

namespace App\Form;

use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YoutubeVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('duration', NumberType::class);
        $builder->add('video', TextType::class);
        $builder->add('category', EntityType::class, [
            'class' => YoutubeCategory::class,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YoutubeVideo::class,
            'constraints' => new UniqueEntity([
                'fields' => [
                    'video',
                ],
            ]),
        ]);
    }
}
