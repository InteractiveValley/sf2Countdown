<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table(name="direcciones")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\DireccionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Direccion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_direccion", type="string", length=255)
     */
    private $tipoDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="num_exterior", type="string", length=255)
     */
    private $numExterior;

    /**
     * @var string
     *
     * @ORM\Column(name="num_interior", type="string", length=255)
     */
    private $numInterior;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=6)
     */
    private $cp;

    /**
     * @var integer
     *
     * @ORM\Column(name="municipio", type="string", length=255)
     */
    private $municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="colonia", type="string", length=255)
     */
    private $colonia;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=255)
     */
    private $contacto;

    /**
     * @var string
     *
     * @ORM\Column(name="paqueteria", type="string", length=255)
     */
    private $paqueteria;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime",nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     */
    private $updatedAt;

    /**
     * @var InteractiveValley\BackendBundle\Entity\Usuario
     * @todo Usuario de la direccion
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\BackendBundle\Entity\Usuario", inversedBy="direcciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;
    
    const TIPO_DIRECCION_FACTURACION=1;
    const TIPO_DIRECCION_ENVIO=2;
        
    static public $sTipoDireccion=array(
        self::TIPO_DIRECCION_FACTURACION=>'Facturacion',
        self::TIPO_DIRECCION_ENVIO=>'Envio'
    );
	
    public function getStringTipoDireccion(){
        return self::$sTipoDireccion[$this->getTipoDireccion()];
    }
    
    static function getArrayTipoDireccion(){
        return self::$sTipoDireccion;
    }
    
    static function getPreferedTipoDireccion(){
        return array(self::TIPO_DIRECCION_ENVIO);
    }
    
    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tipoDireccion
     *
     * @param string $tipoDireccion
     * @return Direccion
     */
    public function setTipoDireccion($tipoDireccion)
    {
        $this->tipoDireccion = $tipoDireccion;

        return $this;
    }

    /**
     * Get tipoDireccion
     *
     * @return string 
     */
    public function getTipoDireccion()
    {
        return $this->tipoDireccion;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numExterior
     *
     * @param string $numExterior
     * @return Direccion
     */
    public function setNumExterior($numExterior)
    {
        $this->numExterior = $numExterior;

        return $this;
    }

    /**
     * Get numExterior
     *
     * @return string 
     */
    public function getNumExterior()
    {
        return $this->numExterior;
    }

    /**
     * Set num_interior
     *
     * @param string $numInterior
     * @return Direccion
     */
    public function setNumInterior($numInterior)
    {
        $this->numInterior = $numInterior;

        return $this;
    }

    /**
     * Get num_interior
     *
     * @return string 
     */
    public function getNumInterior()
    {
        return $this->numInterior;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return Direccion
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set municipio
     *
     * @param integer $municipio
     * @return Direccion
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return integer 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set colonia
     *
     * @param integer $colonia
     * @return Direccion
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return integer 
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Direccion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Direccion
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set paqueteria
     *
     * @param string $paqueteria
     * @return Direccion
     */
    public function setPaqueteria($paqueteria)
    {
        $this->paqueteria = $paqueteria;

        return $this;
    }

    /**
     * Get paqueteria
     *
     * @return string 
     */
    public function getPaqueteria()
    {
        return $this->paqueteria;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Direccion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Direccion
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set usuario
     *
     * @param \InteractiveValley\BackendBundle\Entity\Usuario $usuario
     * @return Direccion
     */
    public function setUsuario(\InteractiveValley\BackendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \InteractiveValley\BackendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
