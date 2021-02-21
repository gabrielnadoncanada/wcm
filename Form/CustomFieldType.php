<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\Block;
use Nadmin\WcmBundle\Model\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenTypeModelModel;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'              => 'bci.cms.block.name',
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'data-ice' => 'block.loadBtnCpy',
                    'data-ice-params' => 'data-cc',
                    'labelIn' => true
                ]
            ])
            ->add('value', TextType::class, [
                'label'              => 'bci.cms.block.value',
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'data-ice' => 'block.loadBtnCpy',
                    'data-ice-params' => 'data-vd',
                    'labelIn' => true
                ]
            ])
            ->add('placeholder', TextType::class, [
                'label'              => 'bci.cms.block.placeholder',
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'data-ice' => 'block.loadBtnCpy',
                    'data-ice-params' => 'data-plh',
                    'labelIn' => true
                ]
            ])
            ->add('attr', TextareaType::class, [
                'label'              => 'bci.cms.block.attr',
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'data-ice' => 'block.loadBtnCpy',
                    'data-ice-params' => 'data-attr',
                    'labelIn' => true
                ]
            ])
            ->add('tag', ChoiceType::class, [
                'label'              => 'bci.cms.block.tag',
                'translation_domain' => 'cms_bundle',
                'choices' => [
                    'p' => 'p',
                    'H2' => 'h2',
                    'H1' => 'h1',
                    'H3' => 'h3',
                    'H4' => 'h4',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'data-ice' => 'block.loadBtnCpy',
                    'data-ice-params' => 'data-tag',
                    'labelIn' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
        ]);
    }
}
