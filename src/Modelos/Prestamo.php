<?php

namespace Src\Modelos;

// DOCS: https://github.com/brick/date-time
use Brick\DateTime\LocalDateTime;

class Prestamo extends ModeloBase
{

private string $inicio;
private string $vencimiento;
private string $fin;
private Libro $libro;
private Socio $socio;


    public function __construct(?string $id, string $inicio, ?string $vencimiento, ?string $fin, Libro $libro, Socio $socio)

    {
    parent::__construct($id);
    $this->inicio = LocalDateTime::parse($inicio);
    $this->vencimiento = $vencimiento;
    $this->fin = $fin;
    $this->libro = $libro;
    $this->socio = $socio;

    }
    public function serializarBd(): array
    {
        return [
            'id'=> $this->id,
            'inicio'=>(string)$this->inicio,
            'vencimiento'=>(string)$this->vencimiento,
            'fin'=>(string)$this->fin,
            'libroId'=> $this->libro->id(),
            'socioId'=>$this->socio->id()
        ];
    }
       public function serializarJson(): array
       {
        return [
            'id'=>$this->id,
            'inicio'=>$this->inicio,
            'vencimiento'=>(string)$this->vencimiento,
            'fin'=>(string)$this->fin,
            'libro'=>$this->libro->serializarJson(),
            'socio'=>$this->socio->serializarJson()
        ];
       } 


}
