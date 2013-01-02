<?php

namespace src\Entities;

/**
 * Clase creada para simular la encapsulación de la creación de la sentencia SQL.
 */
class Comment 
{
    
    public $id;
    public $author;
    public $email;
    public $content;
    public $created_at;
    public $updated_at;
    
    /**
     * Retorna un SQL de ejemplo para hacer el insert
     * @return string 
     */
    public function getInsertSQL()
    {
        $sql = "INSERT INTO comments(
                author, 
                email, 
                content, 
                created_at
            ) 
            VALUES (%s, %s, %s, '%s')";
        
        $sql = sprintf(
            $sql, 
            $this->author,
            $this->email,
            $this->content,
            date('Y-m-d H:i:s')
        );
        
        return $sql;
    }
    
    /**
     * Retorna un SQL de ejemplo para buscar un comentario cuyo id sea igual a $id
     * @param int $id
     * @return string 
     */
    public static function find($id)
    {
        $sql = "select * 
                from comments
                where id = %d";
        $sql = sprintf($sql, $id);
        
        return $sql;
    }
    
    /**
     * Retorna un SQL de ejemplo para obtener todos los registros y columnas
     * de la tabla
     * @return string 
     */
    public static function findAll()
    {
        $sql = "select * 
                from comments";
        
        return $sql;
    }
    
    /**
     * Retorna un SQL de ejemplo para hacer un update del campo $content al 
     * comentario int $id
     * @param string $content
     * @return string
     */
    public static function getUpdateSQL($id, $content)
    {
        $sql = "update comments
                set content = %s
                where id = %d";
        $sql = sprintf($sql, $content, $id);
        
        return $sql;
    }
    
    /**
     * Retorna un SQL de ejemplo para eliminar el comentario con id igual a $id
     * @param int $id
     * @return string 
     */
    public static function getDeleteSQL($id)
    {
        $sql = "delete from comments
                where id = %d";
        $sql = sprintf($sql, $id);
        
        return $sql;
    }
    
}

?>
