<?php

namespace ShopBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Name',
            'attr' => [
                'class' => 'form-control',
                'id' => 'name',
                'type' => 'text'
            ]
        ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'description',
                    'type' => 'text'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'price',
                    'type' => 'money'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => 'ShopBundle:Category',
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'label' => 'Category',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'category'
                ]
            ])
            ->add('image', FileType::class, [
                'label'=> 'Image',
                'attr' => [
                    'id' => 'image'
                ]
            ])
            ->add('submit', SubmitType::class, [
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
            'data_class' => 'ShopBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopbundle_product';
    }
}
