<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 17/11/17
 * Time: 15:40
 */

namespace App\Form;


use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType{
/**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'placeholder' => '----- Choose a Category -----',
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $repo) {
                    return $repo->createQueryBuilder('c')
                                ->orderBy('c.name');
                }
            ])
            ->add('name')
            ->add('price', NumberType::class,[

            'required' => false,

            'attr' => array(
                'step' => 0.5,
                'precision' => 2,
                'pattern' => '[0-9]+([\.,][0-9]+)'
            ),

        ])
         ->add('description')
         ->add('save', SubmitType::class, array('label' => 'Create Product'));



    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'product';
    }

}