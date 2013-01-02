<?php

namespace src\Entities;

class Comment 
{
    
    public $id;
    public $author;
    public $email;
    public $content;
    public $created_at;
    public $updated_at;
    
    /**
     * Insert query
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
     * Find a comment
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
     * Returns all the rows
     * @return string 
     */
    public static function findAll()
    {
        $sql = "select * 
                from comments";
        
        return $sql;
    }
    
    /**
     * Update the comment based on the ID
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
     * Delete comment based on ID
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
