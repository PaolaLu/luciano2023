<?php

namespace Src\Controladores;

interface ControladorInterface
{
  public static function listar(): array;
  public static function buscarPorId(string $id): ?array;
  public static function crear(array $parametrosCrudos): array;
  public static function actualizar(array $parametrosCrudos): array;
  public static function borrar(string $id): void;
}
