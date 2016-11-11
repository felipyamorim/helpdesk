<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil", uniqueConstraints={@ORM\UniqueConstraint(name="nome_UNIQUE", columns={"nome"})})
 * @ORM\Entity
 */
class Perfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPerfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerfil;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * Get idperfil
     *
     * @return integer
     */
    public function getId()
    {
        return $this->idPerfil;
    }

    /**
     * Get idPerfil
     *
     * @return integer
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Perfil
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

    public function __toString()
    {
        return $this->getNome();
    }
}
