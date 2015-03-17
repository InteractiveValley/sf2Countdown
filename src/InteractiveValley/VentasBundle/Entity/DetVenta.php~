<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetVenta
 *
 * @ORM\Table(name="detalles_venta")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\DetVentaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class DetVenta
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
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

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
     * @ORM\Column(name="importe", type="decimal")
     */
    private $importe;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\VentasBundle\Entity\Venta", inversedBy="detVentas")
     *  @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="venta_id", referencedColumnName="id")
     * })
     */
    private $venta;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\ProductosBundle\Entity\Producto")
     *  @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * })
     */
    private $producto;

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DetVenta
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return DetVenta
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
     * @return DetVenta
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
     * Set importe
     *
     * @param string $importe
     * @return DetVenta
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set venta
     *
     * @param \InteractiveValley\VentasBundle\Entity\Venta $venta
     * @return DetVenta
     */
    public function setVenta(\InteractiveValley\VentasBundle\Entity\Venta $venta = null)
    {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return \InteractiveValley\VentasBundle\Entity\Venta 
     */
    public function getVenta()
    {
        return $this->venta;
    }


    /**
     * Set producto
     *
     * @param \InteractiveValley\ProductosBundle\Entity\Producto $producto
     * @return DetVenta
     */
    public function setProducto(\InteractiveValley\ProductosBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \InteractiveValley\ProductosBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }
}
