<?php

namespace Src\Bd;

use PDO;
use PDOStatement;
use Src\Modelos\Libro;
use Src\Modelos\ModeloBase;

final class LibroDao extends DaoAbstracto
{

    public static function listar(): array
    {
        $datos=self::ejecutar("SELECT * from libros ",[],function( PDO $con,PDOStatement $consulta){
            return $consulta->fetchAll(PDO::FETCH_NUM);
        });
            $instancias = [];
            foreach ($datos as $fila) {
               
                $libro = new Libro($fila[0], $fila[1], $fila[2], $fila[3], intval($fila[4]));
                $instancias[] = $libro;
            }

            return $instancias;
    }

    public static function buscarPorId(string $id)
{
    $query = "SELECT * FROM libros WHERE id = :id LIMIT 1";
    $parametros = array(":id" => $id);
    
    $datos = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
        return $consulta->fetch(PDO::FETCH_ASSOC);
    });
    $libro = new Libro($datos['id'], $datos['isbn'], $datos['titulo'], $datos['autor'],
     intval($datos['edicion']));
    return $libro;
}



    public static function persistir(ModeloBase $libro):void
    {
     
        $query = "INSERT INTO libros (id,isbn, titulo, edicion, autor) VALUES 
        (:id,:isbn, :titulo, :edicion, :autor)";
        $parametros = $libro->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
        
    
    }
    
    public static function actualizar(ModeloBase $instancia): void
    {
        $query = "UPDATE libros  SET isbn=:isbn, titulo = :titulo, edicion=:edicion, autor=:autor
         where id=:id";
        $parametros = $instancia->serializarBd();
        
        $resultado = self::ejecutar($query, $parametros, function(PDO $con, PDOStatement $consulta) {
           
        });
    }

  
    
    public static function borrar(string $id): void
    {
        $sql="delete from libros where id= :id";
        $parametros = array(":id" => $id);

    $consulta = self::ejecutar($sql,$parametros, function(PDO $con, PDOStatement $consulta){});

    
    }
    
}
