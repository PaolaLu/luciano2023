<?php

namespace PublicApp;

use Middlewares\TrailingSlash;
use Slim\Factory\AppFactory;
use Src\Rutas\GlobalRutas;
use Src\Rutas\JsonRespuestaMiddleware;
use Src\Rutas\LibroRutas;
use Src\Rutas\PrestamoRutas;
use Src\Rutas\SocioRutas;

require_once __DIR__ . '/../env.php';

$app = AppFactory::create();

$app->add(new JsonRespuestaMiddleware());
$app->add(new TrailingSlash());

GlobalRutas::configurar($app);
LibroRutas::configurar($app);
SocioRutas::configurar($app);
PrestamoRutas::configurar($app);

$app->run();
