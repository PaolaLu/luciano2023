<?php

namespace Src\Bd\Tests;

use Src\Bd\LibroDao;
use Src\Modelos\Libro;

// Ejecución del test

Rehidratador::ejecutar();

$test = new LibroDaoTest();

$test->testListar();
$test->testCrear();
$test->testBuscar();
$test->testActualizar();
$test->testBorrar();

// Definición del test

class LibroDaoTest
{
  private static string $id;

  public function testListar(): void
  {
    $libros = LibroDao::listar();

    if (!sizeof($libros)) {
      throw new \Exception('Arreglo vacío');
    }

    foreach ($libros as $libro) {
      if (!($libro instanceof Libro)) {
        throw new \Exception(
          'LibroDaoTest::testListar => ¡Falló! ' .
            "variable $libro no es instancia de Libro"
        );
      }
    }

    echo "\nLibroDaoTest::testListar => ¡Éxito!\n\n";
  }

  public function testCrear(): void
  {
    $instancia = new Libro(
      null,
      '1234567890',
      'Nuevo libro',
      'Nuevo autor',
      2025
    );

    static::$id = $instancia->id();

    LibroDao::persistir($instancia);

    echo "\nLibroDaoTest::testCrear => ¡Éxito!\n\n";
  }

  public function testBuscar(): void
  {
    $id = static::$id;
    $instancia = LibroDao::buscarPorId($id);

    if (is_null($instancia)) {
      throw new \Exception(
        'LibroDaoTest::testBuscar => ¡Falló! ' .
          "No se encontró el libro con ID $id"
      );
    }

    echo "\nLibroDaoTest::testBuscar => ¡Éxito!\n\n";
  }

  public function testActualizar(): void
  {
    $id = static::$id;
    $antes = LibroDao::buscarPorId($id);

    $antes->setTitulo('Título test');

    LibroDao::actualizar($antes);

    $despues = LibroDao::buscarPorId($id);

    if ($antes->titulo() !== $despues->titulo()) {
      throw new \Exception(
        'LibroDaoTest::testActualizar => ¡Falló! ' .
          "{$antes->titulo()} !== {$despues->titulo()}"
      );
    }

    echo "\nLibroDaoTest::testActualizar => ¡Éxito!\n\n";
  }

  public function testBorrar(): void
  {
    $id = static::$id;

    LibroDao::borrar($id);

    echo "\nLibroDaoTest::testBorrar => ¡Éxito!\n\n";
  }
}
