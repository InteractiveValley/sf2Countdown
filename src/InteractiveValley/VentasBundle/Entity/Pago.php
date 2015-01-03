<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pagos")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\PagoRepository")
 */
class Pago
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
     * @ORM\Column(name="importe", type="decimal")
     */
    private $importe;

    /**
     * @var string
     *
     * @ORM\Column(name="iva", type="decimal")
     */
    private $iva;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="datetime", nullable=true)
     */
    private $fechaPago;

    /**
     * @var integer
     *
     * @ORM\Column(name="forma_pago", type="integer")
     */
    private $formaPago;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="InteractiveValley\VentasBundle\Entity\Venta", mappedBy="pago")
     */
    private $venta;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->venta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set importe
     *
     * @param string $importe
     * @return Pago
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
     * Set iva
     *
     * @param string $iva
     * @return Pago
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
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     * @return Pago
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime 
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set formaPago
     *
     * @param integer $formaPago
     * @return Pago
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return integer 
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * Add venta
     *
     * @param \InteractiveValley\VentasBundle\Entity\Venta $venta
     * @return Pago
     */
    public function addVentum(\InteractiveValley\VentasBundle\Entity\Venta $venta)
    {
        $this->venta[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \InteractiveValley\VentasBundle\Entity\Venta $venta
     */
    public function removeVentum(\InteractiveValley\VentasBundle\Entity\Venta $venta)
    {
        $this->venta->removeElement($venta);
    }

    /**
     * Get venta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVenta()
    {
        return $this->venta;
    }
}
