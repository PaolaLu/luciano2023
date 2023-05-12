<?php

namespace Src\Modelos\Test;

use Exception;
use Src\Modelos\Libro;

$test = new LibroTest();

$test->testSerializarBd();
$test->testSerializarJson();

class LibroTest
{
  public function testSerializarBd()
  {
    $instancia = new Libro(
      null,
      '1234567678',
      'Título test',
      'Autor test',
      2000
    );
    $datos = $instancia->serializarBd();

    static::validarClaves($datos, 'testSerializarBd');

    echo "\nLibroTest::testSerializarBd => ¡Éxito!\n\n";
  }

  public function testSerializarJson()
  {
    $instancia = new Libro(
      null,
      '222222222',
      'Título test 2',
      'Autor test 2',
      1990
    );
    $datos = $instancia->serializarJson();

    static::validarClaves($datos, 'testSerializarJson');

    echo "\nLibroTest::testSerializarJson => ¡Éxito!\n\n";
  }

  public static function validarClaves(array $datos, string $test): void
  {
    $stringsObligatorios = ['id', 'isbn', 'titulo', 'autor'];

    foreach ($stringsObligatorios as $clave) {
      if (!isset($datos[$clave]) || !is_string($datos[$clave])) {
        throw new Exception(
          "LibroTest::$test => ¡Falló!" .
            " Atributo `$clave` es obligatorio y debe ser un `string`"
        );
      }
    }

    $enterosObligatorios = ['edicion'];

    foreach ($enterosObligatorios as $clave) {
      if (!isset($datos[$clave]) || !is_int($datos[$clave])) {
        throw new Exception(
          "LibroTest::$test => ¡Falló!" .
            " Atributo `$clave` es obligatorio y debe ser un `entero`"
        );
      }
    }
  }
}
