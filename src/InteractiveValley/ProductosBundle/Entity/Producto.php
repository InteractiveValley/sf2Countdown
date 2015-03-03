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
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;
	
	/**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=50)
     */
    private $color;

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
     * @ORM\Column(name="reservado", type="integer", nullable=true)
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
     * @ORM\Column(name="is_producto_promocional", type="boolean")
     */
    private $isPromocional;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="es_nuevo", type="boolean")
     */
    private $isNew;    
    
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
    
    const COLOR_ROJO_CARMESI    = '#9F0700';
    const COLOR_AMARILLO        = '#FA9000';
    const COLOR_CAFE            = '#7F5400';
    const COLOR_AZUL            = '#1DA5FF';
    const COLOR_AZUL_MARINO     = '#084664';
    const COLOR_VERDE           = '#3CAE55';
    const COLOR_FIUSA           = '#F500FC';
    const COLOR_GRIS            = '#A0A0A0';
    const COLOR_BLANCO          = '#FFFFFF';
    
    
    static public $sColores=array(
        self::COLOR_ROJO_CARMESI    => 'Rojo Carmesi',
        self::COLOR_AMARILLO        => 'Amarillo',
        self::COLOR_CAFE        => 'Cafe',
        self::COLOR_AZUL        => 'Azul',
        self::COLOR_AZUL_MARINO => 'Azul marino',
        self::COLOR_VERDE       => 'Verde',
        self::COLOR_FIUSA       => 'Fiusa',
        self::COLOR_GRIS        => 'Gris',
        self::COLOR_BLANCO      => 'Blanco'
    );
    static function getPreferedColor(){
        return array(self::COLOR_BLANCO);
    }

    public function getStringColor(){
        return self::$sColores[$this->getColor()];
    }
    static function getArrayColores(){
        return self::$sColores;
    }
    
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
        $this->galerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->isPromocional = false;
        $this->isNew = false;
        $this->unidadMedida = "PZ";
        $this->reservado = 0;
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

    /**
     * Set isPromocional
     *
     * @param boolean $isPromocional
     * @return Producto
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
     * @return Producto
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
     * Set modelo
     *
     * @param string $modelo
     * @return Producto
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
     * Set color
     *
     * @param string $color
     * @return Producto
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }
}
