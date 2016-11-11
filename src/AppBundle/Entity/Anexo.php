<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anexo
 *
 * @ORM\Table(name="anexo", indexes={@ORM\Index(name="fk_Anexo_Chamado1_idx", columns={"chamado"})})
 * @ORM\Entity
 */
class Anexo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAnexo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idAnexo;

    /**
     * @var string
     *
     * @ORM\Column(name="caminho", type="string", length=255, nullable=false)
     */
    private $caminho;

    /**
     * @var \Chamado
     *
     * @ORM\ManyToOne(targetEntity="Chamado", inversedBy="anexos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chamado", referencedColumnName="idChamado")
     * })
     */
    private $chamado;
}
