<?php

namespace LPC\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetVenta
 *
 * @ORM\Table(name="detalles_venta")
 * @ORM\Entity(repositoryClass="LPC\VentasBundle\Repository\DetVentaRepository")
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
     * @ORM\ManyToOne(targetEntity="Venta", inversedBy="detVentas")
     *  @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="venta_id", referencedColumnName="id")
     * })
     */
    private $venta;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="LPC\ProductosBundle\Entity\Producto")
     */
    private $producto;

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
     * @ORM\Column(name="importeIva", type="decimal")
     */
    private $importeIva;

     /**
     * @var string
     *
     * @ORM\Column(name="importe", type="decimal")
     */
    private $importe;


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
     * Set venta
     *
     * @param integer $venta
     * @return DetVenta
     */
    public function setVenta($venta)
    {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return integer 
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * Set producto
     *
     * @param integer $producto
     * @return DetVenta
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return integer 
     */
    public function getProducto()
    {
        return $this->producto;
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
     * Set importeIva
     *
     * @param string $importeIva
     * @return DetVenta
     */
    public function setImporteIva($importeIva)
    {
        $this->importeIva = $importeIva;

        return $this;
    }

    /**
     * Get importeIva
     *
     * @return string 
     */
    public function getImporteIva()
    {
        return $this->importeIva;
    }

     /**
     * Set importe
     *
     * @param string $importe
     * @return DetVenta
     */
    public function setimporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string 
     */
    public function getimporte()
    {
        return $this->importe;
    }
}
