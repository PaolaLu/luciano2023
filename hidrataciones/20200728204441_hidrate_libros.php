<?php

use EndyJasmi\Cuid;
use Src\Bd\Migration;

class HidrateLibros extends Migration
{
  private $tabla = 'libros';

  public static $ids = [];

  public function up()
  {
    $this->buildIds();

    $ids = static::$ids;

    $sql = "INSERT INTO `$this->tabla` VALUES
      ('{$ids[0]}', '9505156103', 'Mafalda 10', 'Joaquín (Quino) Salvador Lavado', 2000),
      ('{$ids[1]}', '9505156098', 'Mafalda 9', 'Joaquín (Quino) Salvador Lavado', 2000),
      ('{$ids[2]}', '9507828958', 'Las Puertitas del Sr. López', 'Horacio Altuna', 1985),
      ('{$ids[3]}', '8420637564', 'La sombra y otros cuentos', 'Hans Christian Andersen', 1850),
      ('{$ids[4]}', '9789870707721', 'Corto Maltés: La juventud', 'Hugo Pratt', 1978),
      ('{$ids[5]}', '9789504002291', 'Cuentos, 1', 'Edgar Allan Poe', 2015),
      ('{$ids[6]}', '9500704285', 'Crónica de una muerte anunciada', 'Gabriel García Márquez', 1965);";

    $this->run($sql);
  }
  public function down()
  {
    $sql = "TRUNCATE TABLE `$this->tabla`;";

    $this->run($sql);
  }

  private function buildIds()
  {
    array_push(
      static::$ids,
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid()
    );
  }
}
