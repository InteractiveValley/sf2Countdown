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
     * @var InteractiveValley\ProductosBundle\Entity\Color
     * @todo color del producto
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\ProductosBundle\Entity\Color")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     * })
     * @ORM\OrderBy({"nombre" = "ASC"})
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
    
    public function getStringColor(){
        if($this->color){
            return $this->color->getNombre();
        }else{
            return "Sin color";
        }
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
     * Set color
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Color $color
     * @return Producto
     */
    public function setColor(\InteractiveValley\ProductosBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \InteractiveValley\ProductosBundle\Entity\Color 
     */
    public function getColor()
    {
        return $this->color;
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
