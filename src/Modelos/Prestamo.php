<?php

namespace Src\Modelos;

use Brick\DateTime\LocalDateTime;

class Prestamo extends ModeloBase
{
    private LocalDateTime $inicio;
    private ?LocalDateTime $vencimiento;
    private ?LocalDateTime $fin;
    private Libro $libro;
    private Socio $socio;

    public function __construct(?string $id, string $inicio, ?string $vencimiento, ?string $fin, Libro $libro, Socio $socio)
    {
        parent::__construct($id);
        $this->inicio = LocalDateTime::parse($this->cambiarFormatoFecha($inicio));
        $this->vencimiento = $vencimiento !== null ? LocalDateTime::parse($this->cambiarFormatoFecha($vencimiento)) : null;        
        $this->fin = $fin !== null ? LocalDateTime::parse($this->cambiarFormatoFecha($fin)) : null;
        $this->libro = $libro;
        $this->socio = $socio;

        // Verificar si el vencimiento es nulo y calcularlo si es necesario
        if ($this->vencimiento === null) {
            $this->vencimiento = $this->inicio->plusDays(7);
        }
    }

    public function serializarBd(): array
    {
        return [
            'id' => $this->id,
            'inicio' => (string) $this->inicio,
            'vencimiento' => $this->vencimiento !== null ? (string) $this->vencimiento : null,
            'fin' => $this->fin !== null ? (string) $this->fin : null,
            'libroId' => $this->libro->id(),
            'socioId' => $this->socio->id()
        ];
    }

    public function serializarJson(): array
    {
        return [
            'id' => $this->id,
            'inicio' => (string) $this->inicio,
            'vencimiento' => $this->vencimiento !== null ? (string) $this->vencimiento : null,
            'fin' => $this->fin !== null ? (string) $this->fin : null,
            'libro' => $this->libro->serializarJson(),
            'socio' => $this->socio->serializarJson()
        ];
    }

    public function vencimiento(): ?LocalDateTime
    {
        return $this->vencimiento;
    }

    public function setFin($fecha){
        $this->fin=LocalDateTime::parse($fecha);
    }

    public  function revertirFormatoFecha($fecha) {
        $nuevaFecha = str_replace('T', ' ', $fecha);
        return $nuevaFecha;
    }

    public static function cambiarFormatoFecha($fecha) {
        $nuevaFecha = str_replace(' ', 'T', $fecha);
        return $nuevaFecha;
    }

    public function fin(){
        return $this->fin;
    }
}

