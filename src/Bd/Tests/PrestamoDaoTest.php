<?php

namespace Src\Bd\Tests;

use Src\Bd\LibroDao;
use Src\Bd\PrestamoDao;
use Src\Bd\SocioDao;
use Src\Modelos\Prestamo;

// Ejecución del test

Rehidratador::ejecutar();

$test = new PrestamoDaoTest();

$test->testListar();
$test->testCrear();
$test->testBuscar();
$test->testActualizar();
$test->testBorrar();

// Definición del test

class PrestamoDaoTest
{
  private static string $id;

  public function testListar(): void
  {
    $instancias = PrestamoDao::listar();

    if (!sizeof($instancias)) {
      throw new \Exception('Arreglo vacío');
    }

    foreach ($instancias as $instancia) {
      if (!($instancia instanceof Prestamo)) {
        throw new \Exception(
          "\nPrestamoDaoTest::testListar => ¡Falló! " .
            "variable $instancia no es instancia de Prestamo\n\n"
        );
      }
    }

    echo "\nPrestamoDaoTest::testListar => ¡Éxito!\n\n";
  }

  public function testCrear(): void
  {
    $libros = LibroDao::listar();
    $socios = SocioDao::listar();

    $instancia = new Prestamo(
      null,
      '1989-12-23T18:23:32',
      '1989-12-28T18:23:32',
      null,
      // Como no sabemos a priori cuáles son los IDs,
      // traemos todos y elegimos uno al azar.
      $libros[rand(0, count($libros) - 1)],
      $socios[rand(0, count($socios) - 1)]
    );

    static::$id = $instancia->id();

    PrestamoDao::persistir($instancia);

    echo "\nPrestamoDaoTest::testCrear => ¡Éxito!\n\n";
  }

  public function testBuscar(): void
  {
    $id = static::$id;
    $instancia = PrestamoDao::buscarPorId($id);

    if (is_null($instancia)) {
      throw new \Exception(
        'PrestamoDaoTest::testBuscar => ¡Falló! ' .
          "No se encontró el préstamo con ID $id"
      );
    }

    echo "\nPrestamoDaoTest::testBuscar => ¡Éxito!\n\n";
  }

  public function testActualizar(): void
  {
    $id = static::$id;
    $antes = PrestamoDao::buscarPorId($id);

    $antes->setFin('2020-12-27T15:23:32');

    PrestamoDao::actualizar($antes);

    $despues = PrestamoDao::buscarPorId($id);

    if ($antes->fin() !== $despues->fin()) {
      throw new \Exception(
        "\nPrestamoDaoTest::testActualizar => ¡Falló! {$antes->fin()}" .
          " !== {$despues->fin()}\n\n"
      );
    }

    echo "\nPrestamoDaoTest::testActualizar => ¡Éxito!\n\n";
  }

  public function testBorrar(): void
  {
    $id = static::$id;

    LibroDao::borrar($id);

    echo "\nPrestamoDaoTest::testBorrar => ¡Éxito!\n\n";
  }
}
