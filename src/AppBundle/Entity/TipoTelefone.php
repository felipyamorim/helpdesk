<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipotelefone
 *
 * @ORM\Table(name="tipotelefone", uniqueConstraints={@ORM\UniqueConstraint(name="nome_UNIQUE", columns={"nome"})})
 * @ORM\Entity
 */
class TipoTelefone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoTelefone", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoTelefone;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    public function __toString()
    {
        return $this->getNome();
    }

    /**
     * Get idTipoTelefone
     *
     * @return integer
     */
    public function getIdTipoTelefone()
    {
        return $this->idTipoTelefone;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return TipoTelefone
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
}
