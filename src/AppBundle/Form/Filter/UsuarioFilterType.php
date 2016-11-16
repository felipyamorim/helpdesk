<?php

namespace AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class UsuarioFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUsuario', Filters\NumberFilterType::class, array(
                'label' => 'Id'
            ))
            ->add('nome', Filters\TextFilterType::class)
            ->add('email', Filters\TextFilterType::class)
            ->add('perfil', Filters\EntityFilterType::class, array(
                'class' => 'AppBundle\Entity\Perfil'
            ))
            ->add('unidade', Filters\EntityFilterType::class, array(
                'class' => 'AppBundle\Entity\Unidade'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal' => false,
            'data_class' => 'AppBundle\Entity\Usuario',
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
        ));
    }
}
