<?php

namespace LPC\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="LPC\VentasBundle\Entity\VentaRepository")
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
     * @var integer
     *
     * @ORM\Column(name="usuario", type="integer")
     */
    private $usuario;

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
     * @var integer
     *
     * @ORM\Column(name="pago", type="integer")
     */
    private $pago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCompra", type="datetime")
     */
    private $fechaCompra;

    /**
     * @var integer
     *
     * @ORM\Column(name="envio", type="integer")
     */
    private $envio;

    /**
    * @var integer
    *
    * @ORM\OneToMany(targetEntity="LPC\VentasBundle\Entity\DetVenta",mappedBy="venta")
    * @ORM\OrderBy({"id" = "DESC"})
    */
    private $detVentas;

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
     * Set usuario
     *
     * @param integer $usuario
     * @return Venta
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return integer 
     */
    public function getUsuario()
    {
        return $this->usuario;
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
     * Set pago
     *
     * @param integer $pago
     * @return Venta
     */
    public function setPago($pago)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return integer 
     */
    public function getPago()
    {
        return $this->pago;
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
     * Set envio
     *
     * @param integer $envio
     * @return Venta
     */
    public function setEnvio($envio)
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * Get envio
     *
     * @return integer 
     */
    public function getEnvio()
    {
        return $this->envio;
    }
}
