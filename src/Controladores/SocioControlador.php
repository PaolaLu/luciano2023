<?php

namespace Src\Controladores;

use Src\Bd\SocioDao;
use Src\Modelos\Socio;

class SocioControlador implements ControladorInterface
{
    public static function listar(): array{
        $nuevodao= new SocioDao();
        $sociosDao= $nuevodao->listar();
        $socios=[];
        foreach($sociosDao as $socio){
            $serializado= $socio->serializarBD();
            $socios[]= $serializado;
        }
        return $socios;
    }
    public static function buscarPorId(string $id): ?array{

        $nuevodao= new SocioDao();
        $socioDao=$nuevodao->buscarPorId($id);
        $socio=[];
        $serializado=$socioDao->serializarJson();
        $socio[]=$serializado;
        return $socio;

        
    }
    public static function crear(array $parametrosCrudos): array{

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
