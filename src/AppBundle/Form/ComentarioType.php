<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mensagem', TextareaType::class, array(
                'label' => false,
                'horizontal_input_wrapper_class' => false,
                'attr' => array('maxlength' => 100, 'rows' => 5)
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal' => false,
            'data_class' => 'AppBundle\Entity\Comentario'
        ));
    }

    public function getName()
    {
        return 'app_bundle_comentario';
    }
}
