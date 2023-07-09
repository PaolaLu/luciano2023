<?php

namespace Src\Controladores;

use Src\Bd\LibroDao;
use Src\Bd\PrestamoDao;
use Src\Bd\SocioDao;
use Src\Modelos\Prestamo;


class PrestamoControlador implements ControladorInterface
{

    public static function listar(): array{
   
        $prestamosDao= PrestamoDao::listar();
        $prestamos = [];

        foreach ($prestamosDao as $prestamo){
            $serializado = $prestamo->serializarBd();
            $prestamos[]=$serializado;
        }
        return $prestamos;
    }

    
    public static function buscarPorId(string $id): ?array{
    
       $prestamo= PrestamoDao::buscarPorId($id);
    
        return [$prestamo->serializarBd()];
    }


    public static function crear(array $parametrosCrudos): array{

        $libro=LibroDao::buscarDisponiblePorId($parametrosCrudos[3]['id']);
        $socio=SocioDao::buscarDisponiblePorId($parametrosCrudos[4]['id']);
        $prestamo= new Prestamo(null,$parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$libro,$socio);  
        PrestamoDao::persistir($prestamo);
   
        return [$prestamo];
    }

    public static function actualizar(array $parametrosCrudos): array
    {
     
        $libroDao=new LibroDao();
        $socioDao=new SocioDao();
        $libro=$libroDao->buscarPorId($parametrosCrudos[4]);
        $socio=$socioDao->buscarPorId($parametrosCrudos[5]);  
        $prestamo= new Prestamo($parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$parametrosCrudos[3],$libro,$socio);
        PrestamoDao::actualizar($prestamo);
        return [$prestamo];
    }

    public static function borrar(string $id): void{

        PrestamoDao::borrar($id);

    }
}
