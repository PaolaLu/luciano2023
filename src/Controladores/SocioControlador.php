<?php

namespace Src\Controladores;

use Src\Bd\SocioDao;
use Src\Modelos\Socio;

class SocioControlador implements ControladorInterface
{
    public static function listar(): array{
        $sociodao= new SocioDao();
        $socios=  $sociodao->listar();
        return [$socios];
    }
    public static function buscarPorId(string $id): ?array{

        $nuevodao= new SocioDao();
        $nuevodao->buscarPorId($id);
    
        return [$nuevodao->buscarPorId($id)];

        
    }
    public static function crear(array $parametrosCrudos): array{
        print_r($parametrosCrudos);
        $sociodao=new SocioDao();
        $socio= new Socio(null,$parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2]);
        $sociodao->persistir($socio);
   
        return [$socio];
    }
    public static function actualizar(array $parametrosCrudos): array
    {
        $nuevodao= new SocioDao();
        $socio= new Socio($parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$parametrosCrudos[3]);
        $nuevodao->actualizar($socio);
        return [$socio];
    }
    public static function borrar(string $id): void{

        $nuevodao= new SocioDao();
        $nuevodao->borrar($id);

    }
}
