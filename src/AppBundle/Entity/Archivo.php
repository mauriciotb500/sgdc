<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="archivo")
 */
class Archivo extends EntidadBase {
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $nombre;
	
	/**
	 * @ORM\Column(type="string", length=45)
	 */
	private $tipo;
	
	/**
	 * @ORM\Column(type="string", length=250)
	 */
	private $path;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Denuncia", cascade={"persist"})
	 * @ORM\JoinColumn(name="denuncia_id", referencedColumnName="id")
	 */
	private $denuncia;
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \AppBundle\Entity\EntidadBase::getMostrarDetalles()
	 */
	public function getMostrarDetalles() {
		return array (
				$this->id,
				$this->nombre,
				$this->tipo,
				$this->path,
				$this->denuncia 
		);
	}
	
	/**
	 *
	 * @return string[]
	 */
	public static function getMostrarCabeceras() {
		return array (
				"id",
				"nombre",
				"tipo",
				"path",
				"denuncia" 
		);
	}
	
	/**
	 *
	 * @return string
	 */
	public static function getNombreEntidad() {
		return "archivo";
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \AppBundle\Entity\EntidadBase::__toString()
	 */
	public function __toString() {
		return $this->nombre;
	}
	
	/**
	 * Set nombre
	 *
	 * @param string $nombre
	 *
	 * @return Archivo
	 */
	public function setNombre($nombre) {
		$this->nombre = $nombre;
		return $this;
	}
	
	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre() {
		return $this->nombre;
	}
	
	/**
	 * Set tipo
	 *
	 * @param string $tipo
	 *
	 * @return Archivo
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;
		
		return $this;
	}
	
	/**
	 * Get tipo
	 *
	 * @return string
	 */
	public function getTipo() {
		return $this->tipo;
	}
	
	/**
	 * Set path
	 *
	 * @param string $path
	 *
	 * @return Archivo
	 */
	public function setPath($path) {
		$this->path = $path;
		
		return $this;
	}
	
	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}
	/**
	 *
	 * @return $denuncia
	 */
	public function getDenuncia() {
		return $this->denuncia;
	}
	
	/**
	 *
	 * @param
	 *        	$denuncia
	 */
	public function setDenuncia($denuncia) {
		$this->denuncia = $denuncia;
	}
}
