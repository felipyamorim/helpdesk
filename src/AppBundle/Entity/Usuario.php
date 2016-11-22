<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})}, indexes={@ORM\Index(name="fk_Usuario_Perfil_idx", columns={"perfil"}), @ORM\Index(name="fk_Usuario_Unidade1_idx", columns={"unidade"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idUsuario;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @UserPassword(groups={"alterar_senha"})
     */
    private $oldSenha;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"alterar_senha"})
     * @Assert\Length(min="8", max="16", groups={"alterar_senha"})
     */
    private $plainPassword;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registrar"})
     * @Assert\Length(min="8", max="16", groups={"registrar"})
     * @ORM\Column(name="senha", type="string", length=45, nullable=false)
     */
    private $senha;

    /**
     * @var Perfil
     *
     * @Assert\NotBlank(groups={"cadastro_admin"})
     * @ORM\OneToOne(targetEntity="Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil", referencedColumnName="idPerfil")
     * })
     */
    private $perfil;

    /**
     * @var Unidade
     *
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade", referencedColumnName="idUnidade")
     * })
     */
    private $unidade;

    /**
     * @var Chamado
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Chamado", mappedBy="usuario")
     */
    private $chamadosUsuario;

    /**
     * @var Chamado
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Chamado", mappedBy="tecnico")
     */
    private $chamadosTecnicos;

    /**
     * @var Telefone
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Telefone", mappedBy="usuario", cascade={"persist"})
     */
    private $telefones;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255)
     */
    private $foto;

    /**
     * @var UploadedFile
     *
     * @Assert\File(maxSize="1M", mimeTypes={"image/*"}, mimeTypesMessage="Formato de arquivo inválido, permitido apenas imagem.")
     */
    private $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chamadosUsuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->chamadosTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->telefones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNome();
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     *
     * @return Usuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return integer
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Usuario
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set oldSenha
     *
     * @param string $senha
     *
     * @return Usuario
     */
    public function setOldSenha($senha)
    {
        $this->oldSenha = $senha;

        return $this;
    }

    /**
     * Get OldSenha
     *
     * @return string
     */
    public function getOldSenha()
    {
        return $this->oldSenha;
    }

    /**
     * Set plainPassword
     *
     * @param string $senha
     *
     * @return Usuario
     */
    public function setPlainPassword($senha)
    {
        $this->plainPassword = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set senha
     *
     * @param string $senha
     *
     * @return Usuario
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set perfil
     *
     * @param \AppBundle\Entity\Perfil $perfil
     *
     * @return Usuario
     */
    public function setPerfil(\AppBundle\Entity\Perfil $perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set unidade
     *
     * @param \AppBundle\Entity\Unidade $unidade
     *
     * @return Usuario
     */
    public function setUnidade(\AppBundle\Entity\Unidade $unidade)
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get unidade
     *
     * @return \AppBundle\Entity\Unidade
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Add chamadosUsuario
     *
     * @param \AppBundle\Entity\Chamado $chamadosUsuario
     *
     * @return Usuario
     */
    public function addChamadosUsuario(\AppBundle\Entity\Chamado $chamadosUsuario)
    {
        $this->chamadosUsuario[] = $chamadosUsuario;

        return $this;
    }

    /**
     * Remove chamadosUsuario
     *
     * @param \AppBundle\Entity\Chamado $chamadosUsuario
     */
    public function removeChamadosUsuario(\AppBundle\Entity\Chamado $chamadosUsuario)
    {
        $this->chamadosUsuario->removeElement($chamadosUsuario);
    }

    /**
     * Get chamadosUsuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChamadosUsuario()
    {
        return $this->chamadosUsuario;
    }

    /**
     * Add chamadosTecnico
     *
     * @param \AppBundle\Entity\Chamado $chamadosTecnico
     *
     * @return Usuario
     */
    public function addChamadosTecnico(\AppBundle\Entity\Chamado $chamadosTecnico)
    {
        $this->chamadosTecnicos[] = $chamadosTecnico;

        return $this;
    }

    /**
     * Remove chamadosTecnico
     *
     * @param \AppBundle\Entity\Chamado $chamadosTecnico
     */
    public function removeChamadosTecnico(\AppBundle\Entity\Chamado $chamadosTecnico)
    {
        $this->chamadosTecnicos->removeElement($chamadosTecnico);
    }

    /**
     * Get chamadosTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChamadosTecnicos()
    {
        return $this->chamadosTecnicos;
    }


    public function getRoles()
    {
        return array($this->getPerfil()->getRole());
    }

    public function getPassword()
    {
        return $this->getSenha();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getNome();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize(array(
            $this->idUsuario,
            $this->email,
            $this->nome,
            $this->senha
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->idUsuario,
            $this->email,
            $this->nome,
            $this->senha
            ) = unserialize($serialized);
    }


    /**
     * Add telefone
     *
     * @param \AppBundle\Entity\Telefone $telefone
     *
     * @return Usuario
     */
    public function addTelefone(\AppBundle\Entity\Telefone $telefone)
    {
        $telefone->setUsuario($this);

        $this->telefones[] = $telefone;

        return $this;
    }

    /**
     * Remove telefone
     *
     * @param \AppBundle\Entity\Telefone $telefone
     */
    public function removeTelefone(\AppBundle\Entity\Telefone $telefone)
    {
        $this->telefones->removeElement($telefone);
    }

    /**
     * Get telefones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTelefones()
    {
        return $this->telefones;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Usuario
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}
