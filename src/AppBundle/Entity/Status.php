<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Status
 *
 * @ORM\Table(name="status", uniqueConstraints={@ORM\UniqueConstraint(name="nome_UNIQUE", columns={"nome"})})
 * @ORM\Entity
 */
class Status
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idStatus", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idStatus;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * Set idstatus
     *
     * @return Status
     */
    public function setId($id)
    {
        $this->idStatus = $id;

        return $this;
    }

    /**
     * Set idstatus
     */
    public function getId()
    {
        return $this->idStatus;
    }

    /**
     * Get idStatus
     *
     * @return integer
     */
    public function getIdStatus()
    {
        return $this->idStatus;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Status
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
