<?php

namespace Src\Bd;

use PDO;
use PDOStatement;
use Src\Modelos\ModeloBase;

final class PrestamoDao extends DaoAbstracto
{
    public static function listar(): array
    {
        $datos = self::ejecutar("SELECT * FROM prestamos ",[],function(PDO $con , PDOStatement $consulta){

            return $consulta->fetchAll(PDO::FETCH_NUM);
        });
            return $datos;

        }
        
        public static function buscarPorId(string $id)
        {$query = "SELECT * FROM prestamos WHERE id = :id LIMIT 1";
            $parametros = array(":id" => $id);
            $datos = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta){
                return $consulta->fetch(PDO::FETCH_ASSOC);
            });
            return $datos;
        }

        public static function persistir(ModeloBase $instancia): void
        {
            $query = "INSERT INTO prestamo (id, inicio, vencimiento, fin, libro_id, socio_id)";
            $parametros = $instancia->serializarBd();
            $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta){

            });
        }
        public static function actualizar(ModeloBase $instancia): void
        {
            $query = "UPDATE prestamos SET inicio=:inicio, vencimiento=:vencimiento, fin=:fin, libro_id=:libro, socio_id=:socio WHERE id=:id";
            $parametros = $instancia->serializarBd();
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta){

        });        
        }
        public static function borrar(string $id): void
        {
            $sql = "DELETE FROM prestamo WHERE id =:id";
            $parametros = array(":id"=> $id);
            $consulta = self::ejecutar($sql, $parametros, function (PDO $con, PDOStatement $consulta){});
            
        }


}
