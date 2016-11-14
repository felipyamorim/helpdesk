<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class RegistrarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('unidade', null, array(
                'required' => true,
                'placeholder' => 'Selecione sua Unidade'
            ))
            ->add('email')
            ->add('senha', Type\RepeatedType::class, array(
                'type' => Type\PasswordType::class,
                'required' => true,
                'invalid_message' => 'As senhas não conferem, digite novamente.',
                'first_options'  => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repetir Senha'),
            ))
            ->add('telefones', Type\CollectionType::class, array(
                //'label' => false,
                'entry_type' => TelefoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array(
                    'icon' => 'plus',
                    'label' => 'Adicionar Telefone',
                    'attr' => array('class' => 'btn btn-primary')
                ),
                'entry_options' => array( // options for collection fields
                    'label_render' => false,
                    'horizontal_input_wrapper_class' => "col-lg-12",
                    'widget_remove_btn' => array(
                        'icon' => 'trash',
                        'label' => 'Remover Item',
                        'attr' => array('class' => 'btn btn-danger')
                    ),
                ),
                'by_reference' => false
            ));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
}
