<?php

namespace Src\Bd;

final class ConexionBd
{
    private static ?\PDO $conexion = null;

    private function __construct()
    {
    }

    public static function conectar(): \PDO
    {
        if (is_null(static::$conexion)) {
            static::$conexion = new \PDO(
                "mysql:host=127.0.0.1;dbname={$_ENV['DB_NAME']};charset=utf8mb4",
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }

        return static::$conexion;
    }

    public function desconectar(): void
    {
        static::$conexion = null;
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }
}
