<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Unidade
 *
 * @ORM\Table(name="unidade")
 * @ORM\Entity
 */
class Unidade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUnidade", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUnidade;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="45", min="5")
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * Get idUnidade
     *
     * @return integer
     */
    public function getIdUnidade()
    {
        return $this->idUnidade;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Unidade
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
