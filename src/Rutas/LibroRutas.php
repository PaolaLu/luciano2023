<?php

namespace Src\Rutas;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Src\Controladores\LibroControlador;

final class LibroRutas implements RutasInterface
{
  public static function configurar(App $app): void
  {
    // API
    $app->get('/api/libros', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson($respuesta, LibroControlador::listar());
    });

    $app->get('/api/libros/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        LibroControlador::buscarPorId($args['id'])
      );
    });

    $app->post('/api/libros', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConJson(
        $respuesta,
        LibroControlador::crear($peticion->getParsedBody())
      );
    });

    $app->put('/api/libros/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      $body = $peticion->getParsedBody();
      $body['id'] = $args['id'];

      return Utileria::responderConJson(
        $respuesta,
        LibroControlador::actualizar($body)
      );
    });

    $app->delete('/api/libros/{id}', function (
      Request $peticion,
      Response $respuesta,
      array $args
    ) {
      LibroControlador::borrar($args['id']);

      // Limpia el buffer de salida para evitar que se intenten
      // publicar al cliente los logs de las queries de la BD.
      ob_clean();

      return $respuesta;
    });

    // Vistas

    $app->get('/libros', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'listados/libros', [
        'titulo' => 'Lista de libros',
      ]);
    });

    $app->get('/libros/crear', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      return Utileria::responderConVista($respuesta, 'creaciones/libro', [
        'titulo' => 'Crear nuevo libro',
      ]);
    });

    $app->get('/libros/editar', function (
      Request $peticion,
      Response $respuesta,
      $args
    ) {
      $params = $peticion->getQueryParams();

      return Utileria::responderConVista($respuesta, 'ediciones/libro', [
        'titulo' => "Edición del libro nº {$params['id']}",
      ]);
    });
  }
}
