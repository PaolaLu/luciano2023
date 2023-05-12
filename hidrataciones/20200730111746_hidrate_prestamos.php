<?php

use Src\Bd\Migration;
// DOCS: https://github.com/brick/date-time
use Brick\DateTime\LocalDateTime;
use EndyJasmi\Cuid;

class HidratePrestamos extends Migration
{
  private $tabla = 'prestamos';

  public static $ids = [];

  public function up()
  {
    $this->buildIds();

    $ids = static::$ids;
    $libros = HidrateLibros::$ids;
    $socios = HidrateSocios::$ids;

    $date1 = $this->getDates('2020-02-04T13:00:00');
    $date2 = $this->getDates('2020-03-05T12:00:00');
    $date3 = $this->getDates('2019-12-16T15:00:00');
    $date4 = $this->getDates('2020-01-11T09:00:00');
    $date5 = $this->getDates('2020-05-23T18:00:00');
    $date6 = $this->getDates('2020-07-14T17:00:00', 21);
    $date7 = $this->getDates('2020-03-21T10:00:00');
    $date8 = $this->getDates('2020-04-02T10:00:00', 66);
    $date9 = $this->getDates('2020-07-25T10:00:00');
    $date10 = $this->getDates('2020-06-12T10:00:00');

    $sql = "INSERT INTO `$this->tabla` VALUES
      ('{$ids[0]}', '$date1[0]', '$date1[1]', '$date1[2]', '{$libros[0]}', '{$socios[0]}'),
      ('{$ids[1]}', '$date2[0]', '$date2[1]', null, '{$libros[0]}', '{$socios[0]}'),

      ('{$ids[2]}', '$date3[0]', '$date3[1]', null, '{$libros[1]}', '{$socios[1]}'),

      ('{$ids[3]}', '$date4[0]', '$date4[1]', '$date4[2]', '{$libros[2]}', '{$socios[2]}'),
      ('{$ids[4]}', '$date5[0]', '$date5[1]', '$date5[2]', '{$libros[3]}', '{$socios[2]}'),
      ('{$ids[5]}', '$date6[0]', '$date6[1]', '$date6[2]', '{$libros[6]}', '{$socios[2]}'),

      ('{$ids[6]}', '$date7[0]', '$date7[1]', '$date7[2]', '{$libros[3]}', '{$socios[4]}'),
      ('{$ids[7]}', '$date8[0]', '$date8[1]', '$date8[2]', '{$libros[5]}', '{$socios[4]}'),

      ('{$ids[8]}', '$date9[0]', '$date9[1]', '$date9[2]', '{$libros[4]}', '{$socios[6]}'),
      ('{$ids[9]}', '$date10[0]', '$date10[1]', '$date10[2]', '{$libros[0]}', '{$socios[6]}');";

    $this->run($sql);
  }
  public function down()
  {
    $sql = "TRUNCATE TABLE `$this->tabla`;";

    $this->run($sql);
  }
  /**
   * @return (string|null)[]
   */
  private function getDates(string $date, int $daysToReturn = 5): array
  {
    return [
      $date,
      (string) LocalDateTime::parse($date)->plusDays(7),
      (string) LocalDateTime::parse($date)->plusDays($daysToReturn),
    ];
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
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid(),
      Cuid::cuid()
    );
  }
}
