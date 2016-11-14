<?php

namespace AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class ChamadoFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idChamado', Filters\TextFilterType::class, array(
                'label' => 'Id do Chamado'
            ))
            ->add('descricao', Filters\TextFilterType::class, array(
                'label' => 'Descrição'
            ))
            ->add('data', Filters\DateTimeFilterType::class)
            ->add('status', Filters\TextFilterType::class)
            ->add('prioridade', Filters\ChoiceFilterType::class, array(
                'placeholder' => 'Selecione a Prioridade',
                'choices' => array(
                    'Baixa' => '1',
                    'Média' => '1',
                    'Alta' => '1'
                )
            ))
            ->add('problema', Filters\TextFilterType::class)
            ->add('usuario', Filters\TextFilterType::class)
            ->add('tecnico', Filters\TextFilterType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal' => false,
            'data_class' => 'AppBundle\Entity\Chamado',
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
        ));
    }
}
