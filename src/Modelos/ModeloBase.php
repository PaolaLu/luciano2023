<?php

namespace Src\Modelos;

use EndyJasmi\Cuid;

abstract class ModeloBase
{
  protected string $id;

  abstract public function serializarBd(): array;
  abstract public function serializarJson(): array;

  public function __construct(?string $id)
  {
    $this->id = $id ? $id : Cuid::cuid();
  }

  public function id(): string
  {
    return $this->id;
  }

  public function esIgual(ModeloBase $instancia): bool
  {
    return $this->id === $instancia->id();
  }
}
