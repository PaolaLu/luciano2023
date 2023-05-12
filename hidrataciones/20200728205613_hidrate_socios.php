<?php

use EndyJasmi\Cuid;
use Src\Bd\Migration;

class HidrateSocios extends Migration
{
  private $tabla = 'socios';

  public static $ids = [];

  public function up()
  {
    $this->buildIds();

    $ids = static::$ids;

    $sql = "INSERT INTO `$this->tabla` VALUES
      ('{$ids[0]}', '11111111', 'Sergio Peña', '2000-02-10'),
      ('{$ids[1]}', '22222222', 'Pamela Sánchez', '2005-12-30'),
      ('{$ids[2]}', '33333333', 'Yesica Ruano', '2010-06-15'),
      ('{$ids[3]}', '44444444', 'Jose Miguel Caballero', '1990-03-05'),
      ('{$ids[4]}', '55555555', 'Ariadna Cantos', '1985-01-25'),
      ('{$ids[5]}', '66666666', 'Andrés Lema', '2012-04-27'),
      ('{$ids[6]}', '77777777', 'Judith Ortega', '1999-08-01');";

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
