<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Validator\Constraints\IsTrue;

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
            ->add('file', Type\FileType::class, array(
                'label' => 'Foto de Perfil'
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
            ))
            ->add('termsAccepted', Type\CheckboxType::class, array(
                'mapped' => false,
                'constraints' => new IsTrue(array('message' => 'Você deve aceitar os termos e condições de uso.')),
                'label' => 'Eu aceito os <a href="#" id="termos">termos</a>'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'validation_groups' => array('Default', 'registrar')
        ));
    }
}
