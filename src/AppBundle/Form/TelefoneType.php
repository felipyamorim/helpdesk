<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class TelefoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoTelefone', null, array(
                'required' => true,
                'placeholder' => 'Selecione o Tipo de Telefone'
            ))
            ->add('numero', null, array(
                'attr' => array(
                    'class' => 'telefone',
                    'maxlength' => 15,
                )
            ))
            ->add('ramal', null, array(
                'attr' => array(
                    'class' => 'ramal',
                    'maxlength' => 5,
                )
            ))
        ;

        $builder->get('numero')
            ->addModelTransformer(new CallbackTransformer(
                function ($numero) {
                    // transform the array to a string
                    return preg_replace( '/[^0-9]/', '', $numero );
                },
                function ($numero) {
                    // transform the string back to an array
                    return preg_replace( '/[^0-9]/', '', $numero );
                }
            ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Telefone'
        ));
    }
}
