<?php

namespace Src\Bd\Tests;

use Phpmig\Api\PhpmigApplication;


class Rehidratador
{
  private static ?PhpmigApplication $app = null;

  private function __construct()
  {
  }
  public static function ejecutar()
  {
    if (!static::$app) {
      $container = require __DIR__ . '/../../../hidratador.php';
      $output = new \Symfony\Component\Console\Output\NullOutput();
      static::$app = new PhpmigApplication($container, $output);
    }

    static::$app->down();
    static::$app->up();
  }
}
