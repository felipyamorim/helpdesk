<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('email')
            ->add('perfil', null, array(
                'required' => true,
                'placeholder' => 'Selecione o Perfil'
            ))
            ->add('unidade', null, array(
                'required' => true,
                'placeholder' => 'Selecione a Unidade'
            ))
            ->add('file', Type\FileType::class, array(
                'required' => false,
                'label' => 'Foto de Perfil',
            ))
            ->add('telefones', Type\CollectionType::class, array(
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $usuario = $event->getData();
            $form = $event->getForm();

            if (!$usuario || null === $usuario->getIdUsuario()) {

                $form->add('senha', Type\RepeatedType::class, array(
                    'type' => Type\PasswordType::class,
                    'position' => array('after' => 'email'),
                    'required' => true,
                    'invalid_message' => 'As senhas não conferem, digite novamente.',
                    'first_options'  => array('label' => 'Noca Senha'),
                    'second_options' => array('label' => 'Confirmar Senha'),
                    'constraints' => array(new NotBlank(), new Length(array('min' => '8', 'max' => '16')))
                ));
            }
        });
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'validation_groups' => array('Default', 'cadastro_admin')
        ));
    }
}
