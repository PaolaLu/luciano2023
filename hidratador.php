<?php

use Phpmig\Adapter;
use Pimple\Container;

require_once __DIR__ . '/env.php';

$container = new Container();

$container['db'] = function () {
  $dbName = $_ENV['DB_NAME'];
  $dbh = new PDO(
    "mysql:dbname=$dbName;host=127.0.0.1;charset=utf8mb4",
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

  return $dbh;
};

$container['phpmig.adapter'] = function ($c) {
  return new Adapter\PDO\Sql($c['db'], 'hidrataciones');
};

$container['phpmig.migrations_path'] = __DIR__ . '/hidrataciones';

$container['phpmig.migrations_template_path'] =
  __DIR__ . '/configs/migration.tmpl';

return $container;
