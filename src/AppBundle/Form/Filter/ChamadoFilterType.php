<?php

namespace AppBundle\Form\Filter;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('problema', Filters\EntityFilterType::class, array(
                'label' => 'Problema',
                'class' => 'AppBundle\Entity\Problema'
            ))
            ->add('data', Filters\DateFilterType::class, array(
                'widget' => 'single_text',
                'format' => 'd-M-y',
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values){
                    if (empty($values['value'])) {
                        return null;
                    }

                    return $filterQuery->getQueryBuilder()
                        ->where('c.data like :data')
                        ->setParameter(':data', $values['value']->format('Y-m-d').' __:__:__');
                }
            ))
            ->add('status', Filters\EntityFilterType::class, array(
                'class' => 'AppBundle\Entity\Status',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.idStatus', 'ASC');
                },
            ))
            ->add('prioridade', Filters\ChoiceFilterType::class, array(
                'placeholder' => 'Selecione a Prioridade',
                'choices' => array(
                    'Baixa' => '1',
                    'Média' => '2',
                    'Alta' => '3'
                )
            ))
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
