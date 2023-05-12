<?php

namespace Src\Bd;

use Phpmig\Migration\Migration as Base;

class Migration extends Base
{
  protected function run(string $sql)
  {
    $container = $this->getContainer();
    /** @var \PDO */
    $db = $container['db'];

    $db->query('SET FOREIGN_KEY_CHECKS = 0;');
    $db->query($sql);
    $db->query('SET FOREIGN_KEY_CHECKS = 1;');
  }
}
