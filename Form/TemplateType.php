<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'              => 'bci.cms.template.name',
                'translation_domain' => 'cms_bundle',
                'required'           => true
            ])
            ->add('structure', TextareaType::class, [
                'label'              => 'bci.cms.template.structure',
                'translation_domain' => 'cms_bundle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Template::class,
        ]);
    }
}
