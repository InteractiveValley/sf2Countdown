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
     * @ORM\Column(name="marca", type="string", length=150)
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
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * @var InteractiveValley\ProductosBundle\Entity\Categoria
     * @todo Categoria del modelo
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\ProductosBundle\Entity\Categoria", inversedBy="modelos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;
    
    /**
     * @ORM\OneToMany(targetEntity="InteractiveValley\ProductosBundle\Entity\Producto", mappedBy="modelo")
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
    
}
