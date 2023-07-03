<?php

namespace Src\Controladores;

use Exception;
use Src\Bd\LibroDao;
use Src\Modelos\Libro;
use Src\Modelos\ModeloBase;

class LibroControlador implements ControladorInterface
{
    public static function listar(): array
    {
        $librosDao =  LibroDao::listar();
        $libros=[];
        foreach($librosDao as $libro){
           $serializado= $libro->serializarBd();
           $libros[]=$serializado;
        }
            return $libros;
    }

    public static function buscarPorId(string $id): ?array
    {
       $libroDao= LibroDao::buscarPorId($id);
       $libro=[];
       $serializado= $libroDao->serializarBd();
       $libro[]=$serializado;
       
        return $libro;
    }

    public static function crear(array $parametrosCrudos): array
    {
        $libro = new Libro(null, $parametrosCrudos[0], $parametrosCrudos[1], $parametrosCrudos[2],
         $parametrosCrudos[3]);
        Librodao::persistir($libro);

        return [$libro];
    }

    public static function actualizar(array $parametrosCrudos): array
    {
        $libro = new Libro($parametrosCrudos[0], $parametrosCrudos[1], $parametrosCrudos[2], $parametrosCrudos[3], $parametrosCrudos[4]);
        LibroDao:: actualizar($libro);
        return [$libro];
    }

    public static function borrar(string $id): void
    {
        LibroDao::borrar($id);
    }
}
