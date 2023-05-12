<?php

use Src\Bd\Migration;

class AddPrestamos extends Migration
{
  private $tabla = 'prestamos';

  public function up()
  {
    $sql = "CREATE TABLE `$this->tabla` (
      `id` varchar(256) NOT NULL,
      `inicio` DATETIME DEFAULT current_timestamp,
      `vencimiento` DATETIME NOT NULL,
      `fin` DATETIME NULL DEFAULT NULL,

      `libro_id` varchar(256) NOT NULL,
      `socio_id` varchar(256) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `prestamos_libros_fk` (`libro_id`),
      KEY `prestamos_socios_fk` (`socio_id`),
      CONSTRAINT `prestamos_libros_fk` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`),
      CONSTRAINT `prestamos_socios_fk` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`)
    );";

    $this->run($sql);
  }
  public function down()
  {
    $sql = "DROP TABLE `$this->tabla`;";

    $this->run($sql);
  }
}
