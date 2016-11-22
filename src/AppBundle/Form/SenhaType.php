<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class SenhaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldSenha', Type\PasswordType::class, array(
                'label' => 'Senha Atual'
            ))
            ->add('plainPassword', Type\RepeatedType::class, array(
                'type' => Type\PasswordType::class,
                'required' => true,
                'invalid_message' => 'As senhas não conferem, digite novamente.',
                'first_options'  => array('label' => 'Noca Senha'),
                'second_options' => array('label' => 'Confirmar Senha')
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
            'validation_groups' => array('alterar_senha')
        ));
    }
}
