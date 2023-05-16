<?php

namespace Src\Bd;

use PDO;
use PDOStatement;
use Src\Modelos\ModeloBase;

final class SocioDao extends DaoAbstracto
{
    public static function listar (): array 
    {
        $datos=self::ejecutar("SELECT * FROM socios",[],function( PDO $con , PDOStatement $consulta){
            return $consulta->fetchAll(PDO::FETCH_NUM);
        });
        return $datos;
    }
    public static function buscarPorId(string $id)
    {
        $query = "SELECT * FROM socios WHERE id = :id LIMIT 1";
        $parametros = array (":id => $id");
        $datos = self::ejecutar($query, $parametros, function (PDO $con, PDOStatement $consulta){
            return $consulta->fetch(PDO::FETCH_ASSOC);
        });
        return $datos;
    }
    public static function persistir(ModeloBase $instancia): void
    {
        $query = "INSERT INTO socios (id, dni, nombre_apellido, nacimiento) VALUE (:id,:dni,:nombre_apellido,:nacimiento)";
        $parametros = $instancia->serializarBd();
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta){

        });
    }
    public static function actualizar(ModeloBase $instancia): void
    {
        $query = "UPDATE socios SET dni=:dni, nombre_apellido=:nombre_apellido,nacimiento=:nacimiento WHERE id=:id";
        $parametros = $instancia->serializarBd();
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta){});
    }

    public static function borrar(string $id): void
    {
        $sql= "DELETE FROM socios WHERE id =:id";
        $parametros = array(":id"=>$id);
        $consulta = self::ejecutar($sql,$parametros, function(PDO $con,PDOStatement $consulta){});
    }


}
