<?php

namespace App\Form;

use App\Entity\YoutubeCategory;
use App\Query\YoutubeVideoQuery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YoutubeVideoQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('q', TextType::class, [
            'required' => false,
            'attr' => [
                'placeholder' => 'Zoek ...',
            ],
        ]);

        $builder->add('category', EntityType::class, [
            'class' => YoutubeCategory::class,
            'required' => false,
            'placeholder' => '- categorie -',
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YoutubeVideoQuery::class,
            'method' => 'GET',
            'csrf_protection' => false,
            'translation_domain' => 'messages',
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
