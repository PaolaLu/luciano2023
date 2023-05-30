<?php

namespace PublicApp;

use Psr\Http\Message\ResponseInterface as Response; //lo agregue yo 
use Psr\Http\Message\ServerRequestInterface as Request; // lo agregue yo
use Middlewares\TrailingSlash;
use Slim\Factory\AppFactory;
use Src\Rutas\GlobalRutas;
use Src\Rutas\JsonRespuestaMiddleware;
use Src\Rutas\LibroRutas;
use Src\Rutas\PrestamoRutas;
use Src\Rutas\SocioRutas;

require_once __DIR__ . '/../env.php';

$app = AppFactory::create();

$app->options('/{routes:.+}', function (Request $request, Response $response) {     // lo agregue yo
    return $response;                                                                      // lo agregue yo  
});                                                                                       // lo agregue yo  

$app->add(function (Request $request, $handler) {                                        // lo agregue yo
    $response = $handler->handle($request);                                               // lo agregue yo
    return $response                                                                        // lo agregue yo
        ->withHeader('Access-Control-Allow-Origin', '*')                                   // lo agregue yo
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')// lo agregue yo
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');// lo agregue yo
});                                                                                  // lo agregue yo

$app->add(new JsonRespuestaMiddleware());
$app->add(new TrailingSlash());

GlobalRutas::configurar($app);
LibroRutas::configurar($app);
SocioRutas::configurar($app);
PrestamoRutas::configurar($app);

$app->run();
