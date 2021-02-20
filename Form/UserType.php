<?php

namespace Nadmin\WcmBundle\Form;

use Nadmin\WcmBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            'roles.admin_bci'  => 'ROLE_SUPER_ADMIN',
            'roles.admin'  => 'ROLE_ADMIN',
        ];

        if (!$options['is_admin']) {
            unset($roles['roles.admin_bci']);
        }

        $builder
            ->add('firstName', TextType::class, [
                'label'              => 'First Name',
                'translation_domain' => 'Wcm_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label'              => 'Last Name',
                'translation_domain' => 'Wcm_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'label'              => 'Username',
                'translation_domain' => 'Wcm_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label'              => 'Email',
                'translation_domain' => 'Wcm_bundle',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('password', PasswordType::class, [
                'label'              => 'Password',
                'translation_domain' => 'Wcm_bundle',
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => false,
            ])
            ->add('role', ChoiceType::class, [
                'label'              => 'Role',
                'translation_domain' => 'Wcm_bundle',
                'choices'  =>  $roles,
                'attr' => [
                    'class' => 'form-control',
                    'col'   => 'col-12',
                    'labelIn' => true
                ],
                'required' => true,
                'placeholder'        => 'roles.placeholder',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_admin' => false
        ]);
    }
}
