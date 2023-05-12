<?php

namespace RoutesListing;

use Slim\Factory\AppFactory;
use Src\Rutas\GlobalRutas;
use Src\Rutas\LibroRutas;
use Src\Rutas\PrestamoRutas;
use Src\Rutas\SocioRutas;

require_once __DIR__ . '/../env.php';

$app = AppFactory::create();

GlobalRutas::configurar($app);
LibroRutas::configurar($app);
SocioRutas::configurar($app);
PrestamoRutas::configurar($app);

$routes = $app->getRouteCollector()->getRoutes();
$list = [];

print_r("\n");
print_r("Listado de rutas disponibles:\n");
print_r("==============================================\n");
print_r("\n");

foreach ($routes as $route) {
  print_r(
    $route->getPattern() . ' ' . json_encode($route->getMethods()) . "\n"
  );
}
