<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => [
                    'class' => 'form-control pull-left',
                    'id' => 'username',
                    'type' => 'text',
                    'disabled' => $options['action'] !== 'register'
                ],
                'required' => $options['action'] === 'register',
                'empty_data'  => null
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control pull-left',
                    'id' => 'email',
                    'type' => 'text',
                    'disabled' => $options['action'] !== 'register'
                ],
                'required' => $options['action'] === 'register',
                'empty_data'  => null
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'name',
                    'type' => 'text'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Surname',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'surname',
                    'type' => 'text'
                ]
            ])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date of Birth',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'date_of_birth',
                    'type' => 'date',
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'address',
                    'type' => 'text'
                ]
            ])
            ->add('password_raw', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'form-control',
                        'id' => 'password',
                        'type' => 'text'
                    ],
                    'required' => $options['action'] === 'register',
                    'empty_data'  => null
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'class' => 'form-control',
                        'id' => 'username',
                        'type' => 'text'
                    ],
                    'required' => $options['action'] === 'register',
                    'empty_data'  => null
                ],
                'required' => $options['action'] === 'register',
                'empty_data'  => null
            ]);
            if($options['action'] === 'self_edit') {
                $builder->add('password_current', PasswordType::class, [
                    'label' => 'Current Password',
                    'attr' => [
                        'class' => 'form-control',
                        'id' => 'password_current',
                        'type' => 'password'
                    ],
                    'required' => $options['action'] === 'self_edit'
                ]);
            }
            $builder->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary pull-right',
                    'style' => 'margin-top: 10px;'
                ]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
