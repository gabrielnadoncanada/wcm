<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\Block;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'              => 'bci.cms.block.block_name',
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'form-control test',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'label'              => false,
                'translation_domain' => 'cms_bundle',
                'attr' => [
                    'class' => 'block_content codemirror'
                ],
                'required' => false,
            ])
            ->add('fields', CollectionType::class, [
                'entry_type' => CustomFieldType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Block::class,
        ]);
    }
}
