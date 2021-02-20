<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isPrincipal',CheckboxType::class, [
                'label' => 'image.principal',
                'translation_domain' => 'image',
                'attr' => [
                    'class' => 'form-control',
                    'col' => 'col-12',
                    'labelIn' => true
                ],
                'required' => false
            ])
            ->add('title',TextType::class, [
                'label' => 'image.title',
                'translation_domain' => 'image',
                'attr' => [
                    'class' => 'form-control',
                    'col' => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('alt',TextType::class, [
                'label' => 'image.alt',
                'translation_domain' => 'image',
                'attr' => [
                    'class' => 'form-control',
                    'col' => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('fileTemp', FileType::class, [
                'translation_domain' => 'image',
                'mapped' => true,
                'required' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'File to large to upload, max size: 1024k/1Mo'
//                        'mimeTypes' => [
//                            'application/pdf',
//                            'application/x-pdf',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
