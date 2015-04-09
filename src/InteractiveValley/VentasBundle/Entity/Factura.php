<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="facturas")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\FacturaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Factura
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
     * @var boolean
     *
     * @ORM\Column(name="isFacturar", type="boolean")
     */
    private $isFacturar;

    /**
     * @var string
     *
     * @ORM\Column(name="rfc", type="string", length=255, nullable=true)
     */
    private $rfc;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_social", type="string", length=255, nullable=true)
     */
    private $razonSocial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="num_exterior", type="string", length=255, nullable=true)
     */
    private $numExterior;

    /**
     * @var string
     *
     * @ORM\Column(name="num_interior", type="string", length=255, nullable=true)
     */
    private $numInterior;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=6, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="colonia", type="string", length=255, nullable=true)
     */
    private $colonia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=255, nullable=true)
     */
    private $municipio;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=255, nullable=true)
     */
    private $ciudad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="email_envio", type="string", length=255, nullable=true)
     */
    private $emailEnvio;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=255, nullable=true)
     */
    private $contacto;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_contacto", type="string", length=255, nullable=true)
     */
    private $telefonoContacto;
    
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
     * @ORM\ManyToOne(targetEntity="InteractiveValley\BackendBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;
    
    public function __construct() {
        $this->isFacturar = true;
    }
    
    public function __toString() {
        return $this->getDireccionCompleta();
    }
    
    public function getDireccionCompleta(){
        return sprintf("%s %s %s %s",
                $this->getCalle(),
                $this->getNumExterior(), 
                $this->getNumInterior(), 
                $this->getColonia());
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
     * Set rfc
     *
     * @param string $rfc
     * @return Factura
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string 
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     * @return Factura
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string 
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Factura
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
     * @return Factura
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
     * Set numInterior
     *
     * @param string $numInterior
     * @return Factura
     */
    public function setNumInterior($numInterior)
    {
        $this->numInterior = $numInterior;

        return $this;
    }

    /**
     * Get numInterior
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
     * @return Factura
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
     * Set colonia
     *
     * @param string $colonia
     * @return Factura
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string 
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     * @return Factura
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Factura
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Factura
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set emailEnvio
     *
     * @param string $emailEnvio
     * @return Factura
     */
    public function setEmailEnvio($emailEnvio)
    {
        $this->emailEnvio = $emailEnvio;

        return $this;
    }

    /**
     * Get emailEnvio
     *
     * @return string 
     */
    public function getEmailEnvio()
    {
        return $this->emailEnvio;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Factura
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
     * Set telefonoContacto
     *
     * @param string $telefonoContacto
     * @return Factura
     */
    public function setTelefonoContacto($telefonoContacto)
    {
        $this->telefonoContacto = $telefonoContacto;

        return $this;
    }

    /**
     * Get telefonoContacto
     *
     * @return string 
     */
    public function getTelefonoContacto()
    {
        return $this->telefonoContacto;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Factura
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
     * @return Factura
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
     * @return Factura
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

    /**
     * Set isFacturar
     *
     * @param boolean $isFacturar
     * @return Factura
     */
    public function setIsFacturar($isFacturar)
    {
        $this->isFacturar = $isFacturar;

        return $this;
    }

    /**
     * Get isFacturar
     *
     * @return boolean 
     */
    public function getIsFacturar()
    {
        return $this->isFacturar;
    }
}
