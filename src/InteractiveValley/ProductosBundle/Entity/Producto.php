<?php

namespace InteractiveValley\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Producto
 *
 * @ORM\Table(name="productos")
 * @ORM\Entity(repositoryClass="InteractiveValley\ProductosBundle\Repository\ProductoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Producto
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad_medida", type="string", length=4)
     */
    private $unidadMedida;

    /**
     * @var integer
     *
     * @ORM\Column(name="existencia", type="integer")
     */
    private $existencia;

    /**
     * @var integer
     *
     * @ORM\Column(name="reservado", type="integer")
     */
    private $reservado;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal")
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="iva", type="decimal")
     */
    private $iva;

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
     * @var string
     * @todo Slug del producto
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var integer
     * @todo Galeria del producto. 
     *
     * @ORM\ManyToMany(targetEntity="InteractiveValley\GaleriasBundle\Entity\Galeria")
     * @ORM\JoinTable(name="productos_galeria")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $galerias;
    
    /**
     * @var InteractiveValley\BackendBundle\Entity\Usuario
     * @todo Autor de la noticia
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\ProductosBundle\Entity\Categoria", inversedBy="productos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;
    
    function __toString() {
        return $this->nombre;
    }
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->galerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Producto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        
        $this->setSlug(RpsStms::slugify($nombre));

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return Producto
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set unidadMedida
     *
     * @param string $unidadMedida
     * @return Producto
     */
    public function setUnidadMedida($unidadMedida)
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    /**
     * Get unidadMedida
     *
     * @return string 
     */
    public function getUnidadMedida()
    {
        return $this->unidadMedida;
    }

    /**
     * Set existencia
     *
     * @param integer $existencia
     * @return Producto
     */
    public function setExistencia($existencia)
    {
        $this->existencia = $existencia;

        return $this;
    }

    /**
     * Get existencia
     *
     * @return integer 
     */
    public function getExistencia()
    {
        return $this->existencia;
    }

    /**
     * Set reservado
     *
     * @param integer $reservado
     * @return Producto
     */
    public function setReservado($reservado)
    {
        $this->reservado = $reservado;

        return $this;
    }

    /**
     * Get reservado
     *
     * @return integer 
     */
    public function getReservado()
    {
        return $this->reservado;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set iva
     *
     * @param string $iva
     * @return Producto
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return string 
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Producto
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
     * @return Producto
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
     * Set slug
     *
     * @param string $slug
     * @return Producto
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add galerias
     *
     * @param \InteractiveValley\GaleriasBundle\Entity\Galeria $galerias
     * @return Producto
     */
    public function addGaleria(\InteractiveValley\GaleriasBundle\Entity\Galeria $galerias)
    {
        $this->galerias[] = $galerias;

        return $this;
    }

    /**
     * Remove galerias
     *
     * @param \InteractiveValley\GaleriasBundle\Entity\Galeria $galerias
     */
    public function removeGaleria(\InteractiveValley\GaleriasBundle\Entity\Galeria $galerias)
    {
        $this->galerias->removeElement($galerias);
    }

    /**
     * Get galerias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalerias()
    {
        return $this->galerias;
    }

    /**
     * Set categoria
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Categoria $categoria
     * @return Producto
     */
    public function setCategoria(\InteractiveValley\ProductosBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \InteractiveValley\ProductosBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Producto
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
