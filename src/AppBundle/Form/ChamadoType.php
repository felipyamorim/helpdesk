<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChamadoType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('problema', null, array(
                'required' => true,
                'placeholder' => 'Selecione o Problema'
            ))
            ->add('descricao', CKEditorType::class, array(
                'label' => 'Descrição',
                'config' => array(
                    'toolbar' =>  array(
                        [ "Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-", "RemoveFormat" ], [ "Styles", "Format", "Font", "FontSize" ], [ "Cut", "Copy", "Paste", "PasteText", "PasteFromWord", "Undo", "Redo" ],
                ),
                    'uiColor' => '#ffffff',
                ),
            ))
            ->add('prioridade', Type\ChoiceType::class, array(
                'placeholder' => 'Selecione a Prioridade',
                'choices' => array(
                    'Baixa' => '1',
                    'Média' => '2',
                    'Alta' => '3'
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $chamado = $event->getData();
            $form = $event->getForm();

            $user = $this->tokenStorage->getToken()->getUser();
            if (!$user) {
                throw new \LogicException(
                    'The FriendMessageFormType cannot be used without an authenticated user!'
                );
            }

            if($user->getPerfil()->getIdPerfil() != 1){
                $form
                    ->add('usuario', EntityType::class, array(
                        'placeholder' => 'Selecione o Usuário',
                        'class' => 'AppBundle\Entity\Usuario',
                        'query_builder' => function(EntityRepository $er){
                            return $er->createQueryBuilder('u')
                                ->join('u.perfil', 'p')
                                ->where('p.idPerfil = :id')
                                ->setParameter(':id', 1);
                        },
                        'constraints' => array(new NotBlank())
                    ));
            }

            if (!$chamado || null === $chamado->getIdChamado()) {
                $form->add('files', Type\FileType::class, array(
                    'label' => 'Anexos',
                    'required' => false,
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
            'data_class' => 'AppBundle\Entity\Chamado',
            'validation_groups' => array('Default')
        ));
    }
}
