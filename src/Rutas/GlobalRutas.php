<?php

namespace Src\Rutas;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

final class GlobalRutas implements RutasInterface
{
  public static function configurar(App $app): void
  {
    $app->get('/', function (Request $peticion, Response $respuesta, $args) {
      return Utileria::responderConVista($respuesta, 'listados/libros', [
        'titulo' => 'TP Final PWD 2020 : Cambiar nombre',
      ]);
    });
  }
}
