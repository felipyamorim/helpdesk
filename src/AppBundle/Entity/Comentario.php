<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Anexo
 *
 * @ORM\Table(name="Comentario", indexes={@ORM\Index(name="fk_Anexo_Chamado1_idx", columns={"chamado"}), @ORM\Index(name="fk_Comentarios_Usuario1", columns={"usuario"})})
 * @ORM\Entity
 */
class Comentario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idComentario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idComentario;

    /**
     * @var Chamado
     *
     * @ORM\ManyToOne(targetEntity="Chamado", inversedBy="comentarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chamado", referencedColumnName="idChamado")
     * })
     */
    private $chamado;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="idUsuario")
     * })
     */
    private $usuario;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="mensagem", type="text")
     */
    private $mensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * Get idComentario
     *
     * @return integer
     */
    public function getIdComentario()
    {
        return $this->idComentario;
    }

    /**
     * Set mensagem
     *
     * @param string $mensagem
     *
     * @return Comentario
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem
     *
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Comentario
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set chamado
     *
     * @param \AppBundle\Entity\Chamado $chamado
     *
     * @return Comentario
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

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Comentario
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
