<?php

namespace InteractiveValley\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Envio
 *
 * @ORM\Table(name="envios")
 * @ORM\Entity(repositoryClass="InteractiveValley\VentasBundle\Repository\EnvioRepository")
 */
class Envio
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
     * @ORM\Column(name="venta", type="integer")
     */
    private $venta;

    /**
     * @var integer
     *
     * @ORM\Column(name="direccion", type="integer")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_guia", type="string", length=255)
     */
    private $numeroGuia;


    

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
     * @return Envio
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
     * Set direccion
     *
     * @param integer $direccion
     * @return Envio
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return integer 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set numeroGuia
     *
     * @param string $numeroGuia
     * @return Envio
     */
    public function setNumeroGuia($numeroGuia)
    {
        $this->numeroGuia = $numeroGuia;

        return $this;
    }

    /**
     * Get numeroGuia
     *
     * @return string 
     */
    public function getNumeroGuia()
    {
        return $this->numeroGuia;
    }
}
