<?php

namespace Src\Bd\Tests;

use Src\Bd\SocioDao;
use Src\Modelos\Socio;

// Ejecución del test

Rehidratador::ejecutar();

$test = new SocioDaoTest();

$test->testListar();
$test->testCrear();
$test->testBuscar();
$test->testActualizar();
$test->testBorrar();

// Definición del test

class SocioDaoTest
{
  private static string $id;

  public function testListar(): void
  {
    $socios = SocioDao::listar();

    if (!sizeof($socios)) {
      throw new \Exception('Arreglo vacío');
    }

    foreach ($socios as $socio) {
      if (!($socio instanceof Socio)) {
        throw new \Exception(
          'SocioDaoTest::testListar => ¡Falló! ' .
            "variable $socio no es instancia de Socio"
        );
      }
    }

    echo "\nSocioDaoTest::testListar => ¡Éxito!\n\n";
  }

  public function testCrear(): void
  {
    $instancia = new Socio(null, '55123456', 'Nuevo Estudiante', '2010-09-25');

    static::$id = $instancia->id();

    SocioDao::persistir($instancia);

    echo "\nSocioDaoTest::testCrear => ¡Éxito!\n\n";
  }

  public function testBuscar(): void
  {
    $id = static::$id;
    $instancia = SocioDao::buscarPorId($id);

    if (is_null($instancia)) {
      throw new \Exception(
        'SocioDaoTest::testBuscar => ¡Falló! ' .
          "No se encontró el socio con ID $id"
      );
    }

    echo "\nSocioDaoTest::testBuscar => ¡Éxito!\n\n";
  }

  public function testActualizar(): void
  {
    $id = static::$id;
    $antes = SocioDao::buscarPorId($id);

    $antes->setNombreApellido('Alfredo test');

    SocioDao::actualizar($antes);

    $despues = SocioDao::buscarPorId($id);

    if ($antes->nombreApellido() !== $despues->nombreApellido()) {
      throw new \Exception(
        'SocioDaoTest::testActualizar => ¡Falló! ' .
          "{$antes->nombreApellido()} !== {$despues->nombreApellido()}"
      );
    }

    echo "\nSocioDaoTest::testActualizar => ¡Éxito!\n\n";
  }

  public function testBorrar(): void
  {
    $id = static::$id;

    SocioDao::borrar($id);

    echo "\nSocioDaoTest::testBorrar => ¡Éxito!\n\n";
  }
}
