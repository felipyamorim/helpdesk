<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AdminChamado
 *
 * @ORM\Table(name="chamado", indexes={@ORM\Index(name="fk_Chamado_Problema1_idx", columns={"problema"}), @ORM\Index(name="fk_Chamado_Usuario1_idx", columns={"usuario"}), @ORM\Index(name="fk_Chamado_Usuario2_idx", columns={"tecnico"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChamadoRepository")
 */
class Chamado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idChamado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idChamado;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="descricao", type="string", length=120, nullable=false)
     */
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataFinalizado", type="datetime", nullable=true)
     */
    private $dataFinalizado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCancelado", type="datetime", nullable=true)
     */
    private $dataCancelado;

    /**
     * @var Status
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="idStatus")
     * })
     */
    private $status;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="prioridade", type="integer", nullable=false)
     */
    private $prioridade;

    /**
     * @var Problema
     *
     *
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="Problema")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="problema", referencedColumnName="idProblema")
     * })
     */
    private $problema;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="chamadosUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="idUsuario")
     * })
     */
    private $usuario;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="chamadosTecnicos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tecnico", referencedColumnName="idUsuario")
     * })
     */
    private $tecnico;

    /**
     * @var Anexo
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Anexo", mappedBy="chamado", cascade={"persist"}, orphanRemoval=true)
     */
    private $anexos;

    /**
     * @var Comentario
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comentario", mappedBy="chamado", cascade={"persist"}, orphanRemoval=true)
     */
    private $comentarios;

    /**
     * @var UploadedFile[]
     *
     * @Assert\Valid()
     *
     * @Assert\Count(max="5")
     *
     * @Assert\All({
     *     @Assert\File(maxSize="1M")
     * })
     */
    private $files;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->anexos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setIdChamado($id)
    {
        $this->idChamado = $id;
        return $this;
    }

    /**
     * Get idChamado
     *
     * @return integer
     */
    public function getIdChamado()
    {
        return $this->idChamado;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Chamado
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Chamado
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
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return Chamado
     */
    public function setStatus(\AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set prioridade
     *
     * @param integer $prioridade
     *
     * @return Chamado
     */
    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;

        return $this;
    }

    /**
     * Get prioridade
     *
     * @return integer
     */
    public function getPrioridade()
    {
        return $this->prioridade;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Set problema
     *
     * @param \AppBundle\Entity\Problema $problema
     *
     * @return Chamado
     */
    public function setProblema(\AppBundle\Entity\Problema $problema = null)
    {
        $this->problema = $problema;

        return $this;
    }

    /**
     * Get problema
     *
     * @return \AppBundle\Entity\Problema
     */
    public function getProblema()
    {
        return $this->problema;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Chamado
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

    /**
     * Set tecnico
     *
     * @param \AppBundle\Entity\Usuario $tecnico
     *
     * @return Chamado
     */
    public function setTecnico(\AppBundle\Entity\Usuario $tecnico = null)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }

    /**
     * Add anexo
     *
     * @param \AppBundle\Entity\Anexo $anexo
     *
     * @return Chamado
     */
    public function addAnexo(\AppBundle\Entity\Anexo $anexo)
    {
        $anexo->setChamado($this);

        $this->anexos[] = $anexo;

        return $this;
    }

    /**
     * Remove anexo
     *
     * @param \AppBundle\Entity\Anexo $anexo
     */
    public function removeAnexo(\AppBundle\Entity\Anexo $anexo)
    {
        $this->anexos->removeElement($anexo);
    }

    /**
     * Get anexos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnexos()
    {
        return $this->anexos;
    }

    /**
     * Add comentario
     *
     * @param \AppBundle\Entity\Comentario $comentario
     *
     * @return Chamado
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentario)
    {
        $comentario->setChamado($this);

        $this->comentarios[] = $comentario;

        return $this;
    }

    /**
     * Remove comentario
     *
     * @param \AppBundle\Entity\Comentario $comentario
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentario)
    {
        $this->comentarios->removeElement($comentario);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set dataFinalizado
     *
     * @param \DateTime $dataFinalizado
     *
     * @return Chamado
     */
    public function setDataFinalizado($dataFinalizado)
    {
        $this->dataFinalizado = $dataFinalizado;

        return $this;
    }

    /**
     * Get dataFinalizado
     *
     * @return \DateTime
     */
    public function getDataFinalizado()
    {
        return $this->dataFinalizado;
    }

    /**
     * Set dataCancelado
     *
     * @param \DateTime $dataCancelado
     *
     * @return Chamado
     */
    public function setDataCancelado($dataCancelado)
    {
        $this->dataCancelado = $dataCancelado;

        return $this;
    }

    /**
     * Get dataCancelado
     *
     * @return \DateTime
     */
    public function getDataCancelado()
    {
        return $this->dataCancelado;
    }
}
