<?php

namespace Src\Modelos;

// DOCS: https://github.com/brick/date-time
use Brick\DateTime\LocalDate;

class Socio extends ModeloBase
{
    private string $dni;
    private string $nombre_apellido;
    private LocalDate $nacimiento;

    public function __construct(?string $id, string $dni, string $nombre_apellido, string $nacimiento)
    {
        parent::__construct($id);
        $this->dni = $dni;
        $this->nombre_apellido = $nombre_apellido;
        $this->nacimiento = LocalDate::parse($nacimiento);
        
    }

    public function serializarBd(): array
    {
        return[
            'id'=>$this->id,
            'dni'=>$this->dni,
            'nombreApellido'=>$this->nombre_apellido,
            'nacimiento'=>(string)$this->nacimiento,
        ];
    }
    public function serializarJson(): array
    {
        return[
              'id'=>$this->id,
              'dni'=> $this->dni,
              'nombreApellido'=>$this->nombre_apellido,
              'nacimiento'=> (string)$this->nacimiento,
        ];
    }
    public function setNombreApellido(string $nuevoNombre): void{
    
         $this->nombre_apellido= $nuevoNombre;
    }
    public function nombreApellido(){
        return $this->nombre_apellido;
    }
}
