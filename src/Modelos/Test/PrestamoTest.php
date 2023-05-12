<?php

namespace Src\Modelos\Test;

// DOCS: https://github.com/brick/date-time
use Brick\DateTime\LocalDateTime;
use Brick\DateTime\Parser\DateTimeParseException;
use EndyJasmi\Cuid;
use Exception;
use Src\Modelos\Libro;
use Src\Modelos\Prestamo;
use Src\Modelos\Socio;

$test = new PrestamoTest();

$test->testFechaInicioErronea();
$test->testFechaVencimientoErronea();
$test->testFechaFinErronea();

$test->testFechaVencimientoEnCreacionDebeFallar();
$test->testFechaFinEnCreacionDebeFallar();
$test->testFechaDeVencimientoDebenSer7Dias();

$test->testSerializarBd();
$test->testSerializarJson();

class PrestamoTest
{
  private Libro $libro;
  private Socio $socio;
  private string $fechaInicio = '2000-01-01T09:00:00';
  private string $fechaVencimiento = '2000-01-08T09:00:00';
  private string $fechaFin = '2000-01-07T09:00:00';

  public function __construct()
  {
    $this->libro = new Libro(
      null,
      '1231231',
      'Titulo test',
      'Autor test',
      2000
    );
    $this->socio = new Socio(null, '12345678', 'Socio test', '1990-01-01');
  }

  public function testFechaInicioErronea()
  {
    $huboExcepcion = false;

    try {
      new Prestamo(
        null,
        'Fecha inicio errónea',
        null,
        null,
        $this->libro,
        $this->socio
      );
    } catch (DateTimeParseException $exc) {
      $huboExcepcion = true;
    }

    if (!$huboExcepcion) {
      throw new Exception(
        'PrestamoTest::testFechaInicioErronea => ¡Falló!' .
          ' La creación debería haber lanzado una excepción' .
          ' si el argumento de la fecha de nacimiento es un dato inválido.'
      );
    }

    echo "\nSocioTest::testFechaInicioErronea => ¡Éxito!\n\n";
  }

  public function testFechaVencimientoErronea()
  {
    $huboExcepcion = false;

    try {
      new Prestamo(
        Cuid::cuid(),
        $this->fechaInicio,
        'Fecha vencimiento errónea',
        null,
        $this->libro,
        $this->socio
      );
    } catch (DateTimeParseException $exc) {
      $huboExcepcion = true;
    }

    if (!$huboExcepcion) {
      throw new Exception(
        'PrestamoTest::testFechaVencimientoErronea => ¡Falló!' .
          ' La creación debería haber lanzado una excepción' .
          ' si el argumento de la fecha de vencimiento es un dato inválido.'
      );
    }

    echo "\nSocioTest::testFechaVencimientoErronea => ¡Éxito!\n\n";
  }

  public function testFechaFinErronea()
  {
    $huboExcepcion = false;

    try {
      new Prestamo(
        Cuid::cuid(),
        $this->fechaInicio,
        $this->fechaVencimiento,
        'Fecha fin errónea',
        $this->libro,
        $this->socio
      );
    } catch (DateTimeParseException $exc) {
      $huboExcepcion = true;
    }

    if (!$huboExcepcion) {
      throw new Exception(
        'PrestamoTest::testFechaFinErronea => ¡Falló!' .
          ' La creación debería haber lanzado una excepción' .
          ' si el argumento de la fecha fin es un dato inválido.'
      );
    }

    echo "\nSocioTest::testFechaFinErronea => ¡Éxito!\n\n";
  }

  public function testFechaVencimientoEnCreacionDebeFallar()
  {
    $huboExcepcion = true;

    try {
      new Prestamo(
        null,
        $this->fechaInicio,
        $this->fechaVencimiento,
        null,
        $this->libro,
        $this->socio
      );
    } catch (Exception $exc) {
      $huboExcepcion = true;
    }

    if (!$huboExcepcion) {
      throw new Exception(
        'PrestamoTest::testFechaVencimientoEnCreacionDebeFallar => ¡Falló!' .
          ' La creación debería haber lanzado una excepción' .
          ' si el argumento de la fecha de vencimiento existe, pero no hay ID.'
      );
    }

    echo "\nSocioTest::testFechaVencimientoEnCreacionDebeFallar => ¡Éxito!\n\n";
  }

  public function testFechaFinEnCreacionDebeFallar()
  {
    $huboExcepcion = true;

    try {
      new Prestamo(
        null,
        $this->fechaInicio,
        null,
        $this->fechaFin,
        $this->libro,
        $this->socio
      );
    } catch (Exception $exc) {
      $huboExcepcion = true;
    }

    if (!$huboExcepcion) {
      throw new Exception(
        'PrestamoTest::testFechaFinEnCreacionDebeFallar => ¡Falló!' .
          ' La creación debería haber lanzado una excepción' .
          ' si el argumento de la fecha fin existe, pero no hay ID.'
      );
    }

    echo "\nSocioTest::testFechaFinEnCreacionDebeFallar => ¡Éxito!\n\n";
  }

  public function testFechaDeVencimientoDebenSer7Dias()
  {
    $fechaInicio = LocalDateTime::parse($this->fechaInicio);
    $fechaVencimiento = $fechaInicio->plusDays(7);

    $prestamo = new Prestamo(
      null,
      $this->fechaInicio,
      null,
      null,
      $this->libro,
      $this->socio
    );

    if (!$fechaVencimiento->isEqualTo($prestamo->vencimiento())) {
      throw new Exception(
        'PrestamoTest::testFechaDeVencimientoDebenSer7Dias => ¡Falló!' .
          ' La creación debería haber seteado la fecha de vencimiento' .
          ' igual a 7 días después que la fecha de inicio.'
      );
    }

    echo "\nSocioTest::testFechaVencimientoEnCreacionDebeFallar => ¡Éxito!\n\n";
  }

  public function testSerializarBd()
  {
    $instancia = new Prestamo(
      Cuid::cuid(),
      $this->fechaInicio,
      $this->fechaVencimiento,
      $this->fechaFin,
      $this->libro,
      $this->socio
    );
    $datos = $instancia->serializarBd();

    $this->validarClavesString(
      ['id', 'inicio', 'vencimiento', 'fin', 'libroId', 'socioId'],
      $datos,
      'testSerializarBd'
    );

    echo "\nSocioTest::testSerializarBd => ¡Éxito!\n\n";
  }

  public function testSerializarJson()
  {
    $instancia = new Prestamo(
      Cuid::cuid(),
      $this->fechaInicio,
      $this->fechaVencimiento,
      $this->fechaFin,
      $this->libro,
      $this->socio
    );
    $datos = $instancia->serializarJson();

    $this->validarClavesString(
      ['id', 'inicio', 'vencimiento', 'fin'],
      $datos,
      'testSerializarJson'
    );

    LibroTest::validarClaves(
      $datos['libro'],
      'PrestamoTest::testSerializarJson'
    );
    SocioTest::validarClaves(
      $datos['socio'],
      'PrestamoTest::testSerializarJson'
    );

    echo "\nSocioTest::testSerializarJson => ¡Éxito!\n\n";
  }

  private function validarClavesString(
    array $claves,
    array $datos,
    string $test
  ): void {
    foreach ($claves as $clave) {
      if (!isset($datos[$clave]) || !is_string($datos[$clave])) {
        throw new Exception(
          "PrestamoTest::$test => ¡Falló!" .
            " Atributo `$clave` es obligatorio y debe ser un `string`"
        );
      }
    }
  }
}
