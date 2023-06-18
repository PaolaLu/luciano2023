<?php

namespace Src\Controladores;

use Src\Bd\PrestamoDao;
use Src\Modelos\Libro;
use Src\Modelos\Socio;
use Src\Modelos\Prestamo;

class PrestamoControlador implements ControladorInterface
{
    public static function listar(): array
    {
        $prestamoDao = new PrestamoDao();
        $prestamos = $prestamoDao->listar();
        return [$prestamos];
    }
    public static function buscarPorId(string $id): ?array
    {
        $nuevodao = new PrestamoDao();
        $nuevodao->buscarPorId($id);
        return [$nuevodao->buscarPorId($id)];

    }
    public static function crear(array $parametrosCrudos): array
    {
        $prestamoDao= new PrestamoDao();
        $libro = new Libro($parametrosCrudos[3][0],$parametrosCrudos[3][1],$parametrosCrudos[3][2],$parametrosCrudos[3][3],intval($parametrosCrudos[3][4]));
        $socio = new Socio($parametrosCrudos[4][0],$parametrosCrudos[4][1],$parametrosCrudos[4][2],$parametrosCrudos[4][3]);
        $prestamo = new Prestamo(null,$parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$libro,$socio);
        $prestamoDao->persistir($prestamo);
        return [$prestamo];
    }
    public static function actualizar(array $parametrosCrudos): array
    {
        $nuevodao = new PrestamoDao();
        $libro = new Libro($parametrosCrudos[4][0],$parametrosCrudos[4][1],$parametrosCrudos[4][2],$parametrosCrudos[4][3],$parametrosCrudos[4][4]);
        $socio = new Socio($parametrosCrudos[5][0],$parametrosCrudos[5][1],$parametrosCrudos[5][2],$parametrosCrudos[5][3]);
        $prestamo = new Prestamo($parametrosCrudos[0],$parametrosCrudos[1],$parametrosCrudos[2],$parametrosCrudos[3],$libro,$socio);
        $nuevodao->actualizar($prestamo);
        return [$prestamo];
    }
    public static function borrar(string $id): void
    {
        $nuevodao = new PrestamoDao();
        $nuevodao->borrar($id);
    }


}
