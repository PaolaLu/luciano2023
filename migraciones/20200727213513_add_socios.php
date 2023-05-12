<?php

use Src\Bd\Migration;

class AddSocios extends Migration
{
  private $tabla = 'socios';

  public function up()
  {
    $sql = "CREATE TABLE `$this->tabla` (
      `id` varchar(256) NOT NULL,
      `dni` varchar(17) NOT NULL,
      `nombre_apellido` varchar(200) NOT NULL,
      `nacimiento` date NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `dni_un` (`dni`)
    );";

    $this->run($sql);
  }
  public function down()
  {
    $sql = "DROP TABLE `$this->tabla`;";

    $this->run($sql);
  }
}
