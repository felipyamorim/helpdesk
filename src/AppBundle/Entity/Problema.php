<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Problema
 *
 * @ORM\Table(name="problema")
 * @ORM\Entity
 */
class Problema
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProblema", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProblema;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="255")
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    public function __toString()
    {
       return $this->getNome();
    }

    /**
     * Get idProblema
     *
     * @return integer
     */
    public function getIdProblema()
    {
        return $this->idProblema;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Problema
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
