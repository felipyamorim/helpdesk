<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Telefone
 *
 * @ORM\Table(name="telefone", indexes={@ORM\Index(name="fk_Telefone_Usuario1_idx", columns={"usuario"}), @ORM\Index(name="fk_Telefone_TipoTelefone1_idx", columns={"tipoTelefone"})})
 * @ORM\Entity
 */
class Telefone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTelefone", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTelefone;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="11")
     * @ORM\Column(name="numero", type="string", length=11, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="ramal", type="string", length=5, nullable=true)
     */
    private $ramal;

    /**
     * @var TipoTelefone
     *
     * @Assert\NotBlank()
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TipoTelefone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoTelefone", referencedColumnName="idTipoTelefone")
     * })
     */
    private $tipoTelefone;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="telefones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="idUsuario")
     * })
     */
    private $usuario;

    /**
     * Set idTelefone
     *
     * @param integer $idTelefone
     *
     * @return Telefone
     */
    public function setIdTelefone($idTelefone)
    {
        $this->idTelefone = $idTelefone;

        return $this;
    }

    /**
     * Get idTelefone
     *
     * @return integer
     */
    public function getIdTelefone()
    {
        return $this->idTelefone;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Telefone
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set ramal
     *
     * @param string $ramal
     *
     * @return Telefone
     */
    public function setRamal($ramal)
    {
        $this->ramal = $ramal;

        return $this;
    }

    /**
     * Get ramal
     *
     * @return string
     */
    public function getRamal()
    {
        return $this->ramal;
    }

    /**
     * Set tipoTelefone
     *
     * @param \AppBundle\Entity\TipoTelefone $tipoTelefone
     *
     * @return Telefone
     */
    public function setTipoTelefone(\AppBundle\Entity\TipoTelefone $tipoTelefone = null)
    {
        $this->tipoTelefone = $tipoTelefone;

        return $this;
    }

    /**
     * Get tipoTelefone
     *
     * @return \AppBundle\Entity\TipoTelefone
     */
    public function getTipoTelefone()
    {
        return $this->tipoTelefone;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Telefone
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
