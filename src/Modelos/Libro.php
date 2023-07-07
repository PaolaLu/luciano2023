<?php

namespace Src\Modelos;

class Libro extends ModeloBase
{
private string $isbn;
private string $titulo;
private string $autor;
private int $edicion;

public function __construct(?string $id,string $isbn, string $titulo, string $autor, int $edicion )

{
    parent::__construct($id);
    $this->isbn = $isbn ;
    $this->titulo = $titulo ;
    $this->autor = $autor ;
    $this->edicion = $edicion ;

}

public function serializarBd(): array
{
    return [
              'id'=> $this->id,
              'isbn'=> $this->isbn,
              'titulo'=> $this->titulo,
              'autor'=> $this->autor,
              'edicion'=> $this->edicion,
    ];
}

public function serializarJson(): array
{
     return [
                'id'=> $this->id,
                'isbn'=> $this->isbn,
                'titulo'=> $this->titulo,
                'autor'=> $this->autor,
                'edicion'=> $this->edicion,
              ];
}

public function setTitulo(string $nuevoTitulo):void {
    $this->titulo=$nuevoTitulo;
}

public function titulo(){
    return $this->titulo;
}
}


