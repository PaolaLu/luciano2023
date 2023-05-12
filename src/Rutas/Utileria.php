<?php

namespace Src\Rutas;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class Utileria
{
  public static function responderConVista(
    Response $respuesta,
    string $vista,
    array $args
  ): Response {
    // Limpia el buffer de salida para evitar que se intenten
    // publicar al cliente los logs de las queries de la BD.
    ob_clean();

    $phpView = new PhpRenderer(__DIR__ . '/../Vistas');

    $phpView->setLayout('plantillas/base.php');

    return $phpView->render($respuesta, "$vista.html", $args);
  }

  public static function responderConJson(Response $respuesta, $datos)
  {
    // Limpia el buffer de salida para evitar que se intenten
    // publicar al cliente los logs de las queries de la BD.
    ob_clean();

    $respuesta->getBody()->write(json_encode($datos));

    return $respuesta->withHeader('Content-Type', 'application/json');
  }
}
