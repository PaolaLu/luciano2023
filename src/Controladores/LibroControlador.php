<?php

namespace Src\Controladores;


use Src\Bd\LibroDao;
use Src\Modelos\Libro;


class LibroControlador implements ControladorInterface
{
    public static function listar(): array
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");
        $nuevodao = new LibroDao();
        $libros =  $nuevodao->listar();

        return $libros;
    }

    public static function buscarPorId(string $id): ?array
    {
        $nuevodao = new LibroDao();
        $nuevodao->buscarPorId($id);

        return [$nuevodao->buscarPorId($id)];
    }

    public static function crear(array $parametrosCrudos): array
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");
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
