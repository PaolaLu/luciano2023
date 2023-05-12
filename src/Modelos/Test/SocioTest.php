<?php

namespace Src\Modelos\Test;

use Brick\DateTime\Parser\DateTimeParseException;
use Exception;
use Src\Modelos\Socio;

$test = new SocioTest();

$test->testProbarQueFalleLaCreacionSiHayDatosErroneos();
$test->testSerializarBd();
$test->testSerializarJson();

class SocioTest
{
  public function testProbarQueFalleLaCreacionSiHayDatosErroneos()
  {
    try {
      new Socio(null, '12345678', 'Nombre y apellido', 'Esto no es una fecha!');
    } catch (DateTimeParseException $exc) {
      echo "\nSocioTest::testProbarQueFalleLaCreacionSiHayDatosErroneos => ¡Éxito!\n\n";

      return;
    }

    throw new Exception(
      'SocioTest::testProbarQueFalleLaCreacionSiHayDatosErroneos => ¡Falló!' .
        ' La creación debería haber lanzado una excepción' .
        ' si el argumento de la fecha de nacimiento es un dato inválido.'
    );
  }

  public function testSerializarBd()
  {
    $instancia = new Socio(null, '12345678', 'Nombre y apellido', '1990-12-25');
    $datos = $instancia->serializarBd();

    static::validarClaves($datos, 'testSerializarBd');

    echo "\nSocioTest::testSerializarBd => ¡Éxito!\n\n";
  }

  public function testSerializarJson()
  {
    $instancia = new Socio(null, '12345678', 'Nombre y apellido', '1990-12-25');
    $datos = $instancia->serializarJson();

    static::validarClaves($datos, 'testSerializarJson');

    echo "\nSocioTest::testSerializarJson => ¡Éxito!\n\n";
  }

  public static function validarClaves(array $datos, string $test): void
  {
    $stringsObligatorios = ['id', 'dni', 'nombreApellido', 'nacimiento'];

    foreach ($stringsObligatorios as $clave) {
      if (!isset($datos[$clave]) || !is_string($datos[$clave])) {
        throw new Exception(
          "SocioTest::$test => ¡Falló!" .
            " Atributo `$clave` es obligatorio y debe ser un `string`"
        );
      }
    }

    $enterosObligatorios = [];

    foreach ($enterosObligatorios as $clave) {
      if (!isset($datos[$clave]) || !is_int($datos[$clave])) {
        throw new Exception(
          "SocioTest::$test => ¡Falló!" .
            " Atributo `$clave` es obligatorio y debe ser un `entero`"
        );
      }
    }
  }
}
