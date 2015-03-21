<?php

namespace InteractiveValley\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Modelo
 *
 * @ORM\Table(name="modelos")
 * @ORM\Entity(repositoryClass="InteractiveValley\ProductosBundle\Repository\ModeloRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Modelo
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
     * @ORM\Column(name="marca", type="string", length=150,nullable=true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
     * @var integer
     *
     * @ORM\Column(name="inventario", type="integer")
     */
    private $inventario;

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
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPromocional", type="boolean")
     */
    private $isPromocional;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isNew", type="boolean")
     */
    private $isNew;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var integer
     * @todo Categorias del modelo. 
     *
     * @ORM\ManyToMany(targetEntity="InteractiveValley\ProductosBundle\Entity\Categoria")
     * @ORM\JoinTable(name="categorias_modelos")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $categorias;
    
    /**
     * @ORM\OneToMany(targetEntity="InteractiveValley\ProductosBundle\Entity\Producto", mappedBy="modelo")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productos;

    const IVA_16            = '1.16';
    const IVA_EXENTO        = '1.0';
    
    static public $sIva=array(
        self::IVA_EXENTO    => 'Exento',
        self::IVA_16        => '16%'
    );
    static function getPreferedIva(){
        return array(self::IVA_16);
    }

    public function getStringIva(){
        return self::$sIva[$this->getIva()];
    }
    static function getArrayIva(){
        return self::$sIva;
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
    
    /*
     * Slugable
     */
    
    /*
     * Esta funcion es para slugar el valor. 
     */
    public function setSlugAtValue()
    {
        $this->slug = RpsStms::slugify($this->getNombre());
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->inventario = 0;
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
     * @return Modelo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * @return Modelo
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
     * @return Modelo
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
     * Set modelo
     *
     * @param string $modelo
     * @return Modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set inventario
     *
     * @param integer $inventario
     * @return Modelo
     */
    public function setInventario($inventario)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return integer 
     */
    public function getInventario()
    {
        return $this->inventario;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Modelo
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
     * @return Modelo
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
     * Set slug
     *
     * @param string $slug
     * @return Modelo
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
     * Set isPromocional
     *
     * @param boolean $isPromocional
     * @return Modelo
     */
    public function setIsPromocional($isPromocional)
    {
        $this->isPromocional = $isPromocional;

        return $this;
    }

    /**
     * Get isPromocional
     *
     * @return boolean 
     */
    public function getIsPromocional()
    {
        return $this->isPromocional;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     * @return Modelo
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean 
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Modelo
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Modelo
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
     * @return Modelo
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
     * Add categorias
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Categoria $categorias
     * @return Modelo
     */
    public function addCategoria(\InteractiveValley\ProductosBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;

        return $this;
    }

    /**
     * Remove categorias
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Categoria $categorias
     */
    public function removeCategoria(\InteractiveValley\ProductosBundle\Entity\Categoria $categorias)
    {
        $this->categorias->removeElement($categorias);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Add productos
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Producto $productos
     * @return Modelo
     */
    public function addProducto(\InteractiveValley\ProductosBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;

        return $this;
    }

    /**
     * Remove productos
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Producto $productos
     */
    public function removeProducto(\InteractiveValley\ProductosBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
