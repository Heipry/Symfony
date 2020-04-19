<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoticiaRepository")
 */
class Noticia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $seccion;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $equipo;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $fecha;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $textoNoticia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textoTitular;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $imagen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeccion(): ?string
    {
        return $this->seccion;
    }

    public function setSeccion(string $seccion): self
    {
        $this->seccion = $seccion;

        return $this;
    }

    public function getEquipo(): ?string
    {
        return $this->equipo;
    }

    public function setEquipo(string $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTextoNoticia(): ?string
    {
        return $this->textoNoticia;
    }

    public function setTextoNoticia(string $textoNoticia): self
    {
        $this->textoNoticia = $textoNoticia;

        return $this;
    }

    public function getTextoTitular(): ?string
    {
        return $this->textoTitular;
    }

    public function setTextoTitular(string $textoTitular): self
    {
        $this->textoTitular = $textoTitular;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }
}
