<?php

namespace Src\Bd;

use Exception;
use PDO;
use PDOStatement;
use Src\Modelos\ModeloBase;
use Src\Modelos\Socio;

final class SocioDao extends DaoAbstracto
{
    public static function listar(): array{
        $datos=self::ejecutar("SELECT * from socios ",[],function( PDO $con,PDOStatement $consulta){
            return $consulta->fetchAll(PDO::FETCH_NUM);
        });
        
        $instancias = [];

        foreach ($datos as $fila) {
           
            $socio= new Socio($fila[0], $fila[1], $fila[2], $fila[3]);
            $instancias[] = $socio;
        }

        return $instancias;
    }
    public static function buscarPorId(string $id){
        $query = "SELECT * FROM socios WHERE id = :id LIMIT 1";
        $parametros = array(":id" => $id);
        
        $datos = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
            return $consulta->fetch(PDO::FETCH_ASSOC);
        });
        
        $socio = new Socio($datos['id'], $datos['dni'], $datos['nombre_apellido'], $datos['nacimiento']);

        return $socio;
    }

    public static function buscarDisponiblePorId(string $id){
       /* $query = "SELECT count(prestamo.*)
        FROM socios socio
        JOIN prestamos prestamo
        ON (prestamo.socio_id = socio.id)
        WHERE socio.id = ?
        AND prestamo.fin IS NULL ";*/
        $query ="SELECT COUNT(*) AS prestamos_count
        FROM prestamos p
        JOIN socios s ON p.socio_id = s.id
        WHERE s.id = :id
        AND p.fin IS NULL";
        $parametros = array(":id" => $id);
        
        $datos = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
            return $consulta->fetch(PDO::FETCH_NUM);
        });
        if($datos[0] >= 2){
            throw new Exception("el socio con id#$id no puede pedir mas prestamo");
        }
        return self::buscarPorId($id);
    }

    public static function persistir(ModeloBase $instancia): void{
        $query = "INSERT INTO socios (id,dni, nombre_apellido,nacimiento) VALUES (:id,:dni, :nombreApellido,:nacimiento)";
        $parametros = $instancia->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
    }
    public static function actualizar(ModeloBase $instancia): void{
        $query = "UPDATE socios  SET dni=:dni, nombre_apellido=:nombreApellido,nacimiento=:nacimiento where id=:id";
        $parametros = $instancia->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
    }
    public static function borrar(string $id): void{
        $sql="delete from socios where id= :id";
        $parametros = array(":id" => $id);

    $consulta = self::ejecutar($sql,$parametros, function(PDO $con, PDOStatement $consulta){});
    }

}
