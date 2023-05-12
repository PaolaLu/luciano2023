<?php

use Src\Bd\Migration;

class AddLibros extends Migration
{
  private $tabla = 'libros';

  public function up()
  {
    $sql = "CREATE TABLE `$this->tabla` (
      `id` varchar(256) NOT NULL,
      `isbn` varchar(20) NOT NULL,
      `titulo` varchar(256) NOT NULL,
      `autor` varchar(256) NOT NULL,
      `edicion` SMALLINT unsigned NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `isbn_un` (`isbn`)
    );";

    $this->run($sql);
  }
  public function down()
  {
    $sql = "DROP TABLE `$this->tabla`;";

    $this->run($sql);
  }
}
