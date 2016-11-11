<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chamado
 *
 * @ORM\Table(name="chamado", indexes={@ORM\Index(name="fk_Chamado_Problema1_idx", columns={"problema"}), @ORM\Index(name="fk_Chamado_Usuario1_idx", columns={"usuario"}), @ORM\Index(name="fk_Chamado_Usuario2_idx", columns={"tecnico"})})
 * @ORM\Entity
 */
class Chamado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idChamado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idChamado;

    /**
     * @var string
     *
     * @ORM\Column(name="decricao", type="string", length=120, nullable=false)
     */
    private $decricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="prioridade", type="integer", nullable=false)
     */
    private $prioridade;

    /**
     * @var \Problema
     *
     * @ORM\OneToOne(targetEntity="Problema")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="problema", referencedColumnName="idProblema")
     * })
     */
    private $problema;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="chamadosUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="idUsuario")
     * })
     */
    private $usuario;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="chamadosTecnicos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tecnico", referencedColumnName="idUsuario")
     * })
     */
    private $tecnico;

    /**
     * @var Anexo
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Anexo", mappedBy="chamado")
     */
    private $anexos;

}
