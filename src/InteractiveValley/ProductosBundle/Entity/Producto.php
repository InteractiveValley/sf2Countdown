<?php

namespace InteractiveValley\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var InteractiveValley\ProductosBundle\Entity\Modelo
     * @todo Modelo del producto
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\ProductosBundle\Entity\Modelo", inversedBy="productos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modelo_id", referencedColumnName="id")
     * })
     */
    private $modelo;
	
    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=50)
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="inventario", type="integer")
     */
    private $inventario;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * @var integer
     * @todo Galeria del producto. 
     *
     * @ORM\ManyToMany(targetEntity="InteractiveValley\GaleriasBundle\Entity\Galeria")
     * @ORM\JoinTable(name="productos_galeria")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $galerias;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->galerias = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set inventario
     *
     * @param integer $inventario
     * @return Producto
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
     * Set position
     *
     * @param integer $position
     * @return Producto
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Producto
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
     * @return Producto
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
     * Set modelo
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Modelo $modelo
     * @return Producto
     */
    public function setModelo(\InteractiveValley\ProductosBundle\Entity\Modelo $modelo = null)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return \InteractiveValley\ProductosBundle\Entity\Modelo 
     */
    public function getModelo()
    {
        return $this->modelo;
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
}
