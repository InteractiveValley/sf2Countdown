<?php

namespace InteractiveValley\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Categoria
 *
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="InteractiveValley\ProductosBundle\Repository\CategoriaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Categoria
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime", nullable=true)
     */
    private $fechaAlta;
    
    /**
     * @var string
     * @todo Slug de la categoria
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="InteractiveValley\ProductosBundle\Entity\Producto", mappedBy="categoria")
     */
    protected $productos;
    
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
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Categoria
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
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Categoria
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
     * Set slug
     *
     * @param string $slug
     * @return Categoria
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
     * Add productos
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Producto $productos
     * @return Categoria
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
