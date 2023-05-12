<?php

namespace Src\Rutas;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Src\Controladores\SocioControlador;

final class SocioRutas implements RutasInterface
{
  public static function configurar(App $app): void
  {
    // API

    $app->get('/api/socios', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson($respuesta, SocioControlador::listar());
    });

    $app->get('/api/socios/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        SocioControlador::buscarPorId($args['id'])
      );
    });

    $app->post('/api/socios', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        SocioControlador::crear($peticion->getParsedBody())
      );
    });

    $app->put('/api/socios/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      $body = $peticion->getParsedBody();
      $body['id'] = $args['id'];

      return Utileria::responderConJson(
        $respuesta,
        SocioControlador::actualizar($body)
      );
    });

    $app->delete('/api/socios/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      SocioControlador::borrar($args['id']);

      // Limpia el buffer de salida para evitar que se intenten
      // publicar al cliente los logs de las queries de la BD.
      ob_clean();

      return $respuesta;
    });

    // Vistas

    $app->get('/socios', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'listados/socios', [
        'titulo' => 'Lista de socios',
      ]);
    });

    $app->get('/socios/crear', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'creaciones/socio', [
        'titulo' => 'Crear nuevo socio',
      ]);
    });

    $app->get('/socios/editar', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      $params = $peticion->getQueryParams();

      return Utileria::responderConVista($respuesta, 'ediciones/socio', [
        'titulo' => "Edición del socio nº {$params['id']}",
      ]);
    });
  }
}
