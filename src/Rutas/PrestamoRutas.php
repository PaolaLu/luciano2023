<?php

namespace Src\Rutas;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Src\Controladores\PrestamoControlador;

final class PrestamoRutas implements RutasInterface
{
  public static function configurar(App $app): void
  {
    // API

    $app->get('/api/prestamos', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        PrestamoControlador::listar()
      );
    });

    $app->get('/api/prestamos/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        PrestamoControlador::buscarPorId($args['id'])
      );
    });

    $app->post('/api/prestamos', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        PrestamoControlador::crear($peticion->getParsedBody())
      );
    });

    $app->put('/api/prestamos/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      $body = $peticion->getParsedBody();
      $body['id'] = $args['id'];

      return Utileria::responderConJson(
        $respuesta,
        PrestamoControlador::actualizar($body)
      );
    });

    $app->delete('/api/prestamos/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      PrestamoControlador::borrar($args['id']);

      // Limpia el buffer de salida para evitar que se intenten
      // publicar al cliente los logs de las queries de la BD.
      ob_clean();

      return $respuesta;
    });

    // Vistas

    $app->get('/prestamos', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'listados/prestamos', [
        'titulo' => 'Lista de préstamos',
      ]);
    });

    $app->get('/prestamos/crear', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'creaciones/prestamo', [
        'titulo' => 'Crear nuevo préstamo',
      ]);
    });

    $app->get('/prestamos/editar', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      $params = $peticion->getQueryParams();

      return Utileria::responderConVista($respuesta, 'ediciones/prestamo', [
        'titulo' => "Edición del préstamo nº {$params['id']}",
      ]);
    });
  }
}
