<?php

namespace Src\Bd;

use Closure;
use PdoDebugger;

abstract class DaoAbstracto implements DaoInterface
{
  /**
   * Ejemplo de uso:
   * ```php
   * static::ejecutar(
   *  "SELECT * FROM socios",
   *  [],
   *  function (PDO $con, PDOStatement $consulta) {
   *    return $consulta->fetch(PDO::FETCH_NUM);
   *  }
   * )
   * ```
   *
   * @param string $sql Consulta SQL.
   * @param array $params Arreglo asociativo con los
   *  parámetros utilizados en la consulta.
   * @param null|Closure $cb Función opcional que se utiliza
   *  para post procesar los datos de la db.
   */
    protected static function ejecutar(
    string $sql,
    array $params,
    ?Closure $cb = null
  ) {
    $conexion = ConexionBd::conectar();
    $consulta = $conexion->prepare($sql);

   // echo PdoDebugger::show($sql, $params) . "\n";

    $consulta->execute($params);

    $data = null;

    if ($cb) {
      $data = $cb($conexion, $consulta);
    }

    $consulta->closeCursor();

    return $data;
  }
}
