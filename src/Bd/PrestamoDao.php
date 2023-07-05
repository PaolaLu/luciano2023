<?php

namespace Src\Bd;

use Exception;
use PDO;
use PDOStatement;
use Src\Modelos\Prestamo;
use Src\Modelos\ModeloBase;
use Brick\DateTime\LocalDateTime;

final class PrestamoDao extends DaoAbstracto
{
    public static function listar(): array{
        $datos=self::ejecutar("SELECT * from prestamos ",[],function( PDO $con,PDOStatement $consulta){
            return $consulta->fetchAll(PDO::FETCH_NUM);
        });
        $instancias = [];

        foreach ($datos as $fila) {
            $libroDao=new LibroDao();
            $libro=$libroDao->buscarPorId($fila[4]);
            $socioDao=new SocioDao();
            $socio=$socioDao->buscarPorId($fila[5]);
            $inicio=$fila[1];
            $vencimiento=$fila[2];
            $fin=$fila[3];
 
            $prestamo = new Prestamo($fila[0], $inicio, $vencimiento, $fin,$libro, $socio);
            
            $instancias[] = $prestamo;
        }

        return $instancias;
    }
    public static function buscarPorId(string $id)
    {
        $query = "SELECT * FROM prestamos WHERE id = :id LIMIT 1";
        $parametros = array(":id" => $id);
        
        $datos = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
            return $consulta->fetch(PDO::FETCH_NUM);
        });
        $libroDao=new LibroDao();
        $libro=$libroDao->buscarPorId($datos[4]);
        $socioDao=new SocioDao();
        $socio=$socioDao->buscarPorId($datos[5]);
        $prestamo = new Prestamo($datos[0], $datos[1], $datos[2], $datos[3],$libro,$socio);
        
        return $prestamo;
    }


    public static function persistir(ModeloBase $instancia): void { 
        $query = "INSERT INTO prestamos (id,inicio, vencimiento,fin,libro_id,socio_id) VALUES (:id,:inicio, :vencimiento,:fin,:libroId,:socioId)";
        $parametros = $instancia->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
    }

    public static function actualizar(ModeloBase $instancia): void {
        $query = "UPDATE prestamos  SET  inicio=:inicio, vencimiento=:vencimiento,fin=:fin,libro_id=:libroId,socio_id=:socioId where id=:id";
        $parametros = $instancia->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
    }
    
    public static function borrar(string $id): void{
        $sql="delete from prestamos where id= :id";
        $parametros = array(":id" => $id);

        $consulta = self::ejecutar($sql,$parametros, function(PDO $con, PDOStatement $consulta){});
    }
   
}
