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
        $nuevodao = new LibroDao();
        $librosDao =  $nuevodao->listar();
        $libros=[];
        foreach($librosDao as $libro){
           $serializado= $libro->serializarBd();
           $libros[]=$serializado;
        }
            return $libros;
    }

    public static function buscarPorId(string $id): ?array
    {
       $nuevodao = new LibroDao();
       $libroDao= $nuevodao->buscarPorId($id);
       $libro=[];
       $serializado= $libroDao->serializarBd();
       $libro[]=$serializado;
       
        return $libro;
    }

    public static function crear(array $parametrosCrudos): array
    {
        $librodao = new LibroDao();
        $libro = new Libro(null, $parametrosCrudos[0], $parametrosCrudos[1], $parametrosCrudos[2], $parametrosCrudos[3]);
        $librodao->persistir($libro);

        return [$libro];
    }

    public static function actualizar(array $parametrosCrudos): array
    {
     
        $nuevodao = new LibroDao();
        $libro = new Libro($parametrosCrudos[0], $parametrosCrudos[1], $parametrosCrudos[2], $parametrosCrudos[3], $parametrosCrudos[4]);
        $nuevodao->actualizar($libro);
        return [$libro];
    }

    public static function borrar(string $id): void
    {
        $nuevodao = new LibroDao();
        $nuevodao->borrar($id);
    }
}
