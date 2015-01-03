<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table(name="ventas")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\VentaRepository")
 */
class Venta
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
     * @ORM\Column(name="fechaCompra", type="datetime")
     */
    private $fechaCompra;

    /**
     * @var InteractiveValley\VentasBundle\Entity\Pago
     * @todo Registro del pago de la venta
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\VentasBundle\Entity\Pago", inversedBy="venta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pago_id", referencedColumnName="id")
     * })
     */
    private $pago;

    /**
     * @var InteractiveValley\VentasBundle\Entity\Direccion
     * @todo Direccion de envio
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\VentasBundle\Entity\Direccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="envio_id", referencedColumnName="id")
     * })
     */
    private $envio;

    /**
    * @var integer
    *
    * @ORM\OneToMany(targetEntity="InteractiveValley\VentasBundle\Entity\DetVenta",mappedBy="venta")
    * @ORM\OrderBy({"id" = "ASC"})
    */
    private $detVentas;
    
    /**
     * @var InteractiveValley\BackendBundle\Entity\Usuario
     * @todo Usuario de la venta
     *
     * @ORM\ManyToOne(targetEntity="InteractiveValley\BackendBundle\Entity\Usuario", inversedBy="ventas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detVentas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Venta
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
     * @return Venta
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
     * Set fechaCompra
     *
     * @param \DateTime $fechaCompra
     * @return Venta
     */
    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;

        return $this;
    }

    /**
     * Get fechaCompra
     *
     * @return \DateTime 
     */
    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    /**
     * Set pago
     *
     * @param \InteractiveValley\VentasBundle\Entity\Pago $pago
     * @return Venta
     */
    public function setPago(\InteractiveValley\VentasBundle\Entity\Pago $pago = null)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return \InteractiveValley\VentasBundle\Entity\Pago 
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set envio
     *
     * @param \InteractiveValley\VentasBundle\Entity\Direccion $envio
     * @return Venta
     */
    public function setEnvio(\InteractiveValley\VentasBundle\Entity\Direccion $envio = null)
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * Get envio
     *
     * @return \InteractiveValley\VentasBundle\Entity\Direccion 
     */
    public function getEnvio()
    {
        return $this->envio;
    }

    /**
     * Add detVentas
     *
     * @param \InteractiveValley\VentasBundle\Entity\DetVenta $detVentas
     * @return Venta
     */
    public function addDetVenta(\InteractiveValley\VentasBundle\Entity\DetVenta $detVentas)
    {
        $this->detVentas[] = $detVentas;

        return $this;
    }

    /**
     * Remove detVentas
     *
     * @param \InteractiveValley\VentasBundle\Entity\DetVenta $detVentas
     */
    public function removeDetVenta(\InteractiveValley\VentasBundle\Entity\DetVenta $detVentas)
    {
        $this->detVentas->removeElement($detVentas);
    }

    /**
     * Get detVentas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetVentas()
    {
        return $this->detVentas;
    }

    /**
     * Set usuario
     *
     * @param \InteractiveValley\BackendBundle\Entity\Usuario $usuario
     * @return Venta
     */
    public function setUsuario(\InteractiveValley\BackendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \InteractiveValley\BackendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
