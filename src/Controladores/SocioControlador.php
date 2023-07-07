<?php

namespace Src\Controladores;

use Src\Bd\SocioDao;
use Src\Modelos\Socio;

class SocioControlador implements ControladorInterface
{
    public static function listar(): array{

        $sociosDao= SocioDao::listar();
        $socios=[];
        foreach($sociosDao as $socio){
            $serializado= $socio->serializarBD();
            $socios[]= $serializado;
        }
        return $socios;
    }
    public static function buscarPorId(string $id): ?array
    {
        $socioDao= SocioDao::buscarPorId($id);
        $socio=[];
        $serializado=$socioDao->serializarJson();
        $socio[]=$serializado;

        return $socio;
       
    }
    public static function crear(array $parametrosCrudos): array{

        $socio= new Socio(null,$parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2]);
        SocioDao::persistir($socio);
   
        return [$socio];
    }
    public static function actualizar(array $parametrosCrudos): array
    {
        $socio= new Socio($parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$parametrosCrudos[3]);
        SocioDao::actualizar($socio);
        return [$socio];
    }
    public static function borrar(string $id): void{

        SocioDao::borrar($id);

    }
}
