<?php

namespace Src\Bd;

use Src\Modelos\ModeloBase;

interface DaoInterface
{
  public static function listar(): array;
  public static function buscarPorId(string $id);
  public static function persistir(ModeloBase $instancia): void;
  public static function actualizar(ModeloBase $instancia): void;
  public static function borrar(string $id): void;
}
