<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\Page;
use Nadmin\WcmBundle\Entity\Template;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('locale')
            ->add('slug')
            ->add('template', EntityType::class, [
                'class'              => Template::class,
                'choice_label'       => 'name',
                'multiple'           => false,
                'expanded'           => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
