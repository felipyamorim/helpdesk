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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idAnexo;

    /**
     * @var string
     *
     * @ORM\Column(name="caminho", type="string", length=255, nullable=false)
     */
    private $caminho;

    /**
     * @var Chamado
     *
     * @ORM\ManyToOne(targetEntity="Chamado", inversedBy="anexos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chamado", referencedColumnName="idChamado")
     * })
     */
    private $chamado;

    /**
     * Set idAnexo
     *
     * @param integer $idAnexo
     *
     * @return Anexo
     */
    public function setIdAnexo($idAnexo)
    {
        $this->idAnexo = $idAnexo;

        return $this;
    }

    /**
     * Get idAnexo
     *
     * @return integer
     */
    public function getIdAnexo()
    {
        return $this->idAnexo;
    }

    /**
     * Set caminho
     *
     * @param string $caminho
     *
     * @return Anexo
     */
    public function setCaminho($caminho)
    {
        $this->caminho = $caminho;

        return $this;
    }

    /**
     * Get caminho
     *
     * @return string
     */
    public function getCaminho()
    {
        return $this->caminho;
    }

    /**
     * Set chamado
     *
     * @param \AppBundle\Entity\Chamado $chamado
     *
     * @return Anexo
     */
    public function setChamado(\AppBundle\Entity\Chamado $chamado = null)
    {
        $this->chamado = $chamado;

        return $this;
    }

    /**
     * Get chamado
     *
     * @return \AppBundle\Entity\Chamado
     */
    public function getChamado()
    {
        return $this->chamado;
    }
}
