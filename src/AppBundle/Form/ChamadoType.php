<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class ChamadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('problema')
            ->add('descricao', Type\TextareaType::class, array(
                'label' => 'Descrição'
            ))
            ->add('prioridade', Type\ChoiceType::class, array(
                'placeholder' => 'Selecione a Prioridade',
                'choices' => array(
                    'Baixa' => '1',
                    'Média' => '2',
                    'Alta' => '3'
                )
            ))
            ->add('usuario')
            ->add('tecnico')

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $chamado = $event->getData();
            $form = $event->getForm();

            if (!$chamado || null === $chamado->getIdChamado()) {
                $form->add('files', Type\FileType::class, array(
                    'label' => 'Anexos',
                    'multiple' => true,
                    'help_block' => 'Você pode enviar mais de 1 arquivo.'
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
            'data_class' => 'AppBundle\Entity\Chamado'
        ));
    }
}
