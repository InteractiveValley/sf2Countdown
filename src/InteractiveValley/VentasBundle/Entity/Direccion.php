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
     * @ORM\Column(name="municipio", type="integer")
     */
    private $municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="colonia", type="integer")
     */
    private $colonia;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer")
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
     * @ORM\Column(name="fecha_alta", type="datetime",nullable=true)
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime",nullable=true)
     */
    private $fechaModificacion;

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

    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getFechaAlta())
        {
          $this->fechaAlta = new \DateTime();
        }
        if(!$this->getFechaModificacion())
        {
          $this->fechaModificacion = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->fechaModificacion = new \DateTime();
    }

    
    /**
     * @var string
     */
    private $num_interior;


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
        $this->num_interior = $numInterior;

        return $this;
    }

    /**
     * Get num_interior
     *
     * @return string 
     */
    public function getNumInterior()
    {
        return $this->num_interior;
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
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Direccion
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Direccion
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
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
