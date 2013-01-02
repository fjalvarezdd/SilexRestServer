<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use src\Entities\Comment;

require_once (BASE_DIR . '/src/Entities/Comment.php');


$app->get('/view-comments.{format}', function() use($app){
    
    $sql = Comment::findAll();
    
    $comments = $app['db']->fetchAll($sql);
    $comments = utf8_converter($comments);
    
    return new Response(json_encode($comments), 200); 
    
});

$app->post('/create-comment.{format}', function(Request $request) use($app){
    
    if (!$comment = $request->get('comment'))
    {
        return new Response('Insufficient parameters', 400);
    }

    $c = new Comment();
    $c->author = $app['db']->quote($comment['author']);
    $c->email = $app['db']->quote($comment['email']);
    $c->content = $app['db']->quote($comment['content']);
    
    $sql = $c->getInsertSQL();
    
    $app['db']->exec($sql);

    return new Response('Comment created', 201);
    
});

$app->put('update-comment/{id}.{format}', function($id) use($app){

    if (!$comment = $app['request']->get('comment'))
    {
        return new Response('Insufficient parameters', 400);
    }
    
    $sql = Comment::find($id);
    
    $comment = $app['db']->fetchAll($sql);
    
    if(empty($comment))
    {
        return new Response('Comment not found.', 404);
    }
    

    $content = $app['db']->quote($comment['content']);
    $sql = Comment::getUpdateSQL($id, $content);
    
    
    $app['db']->exec($sql);
    
    return new Response("Comment with ID: {$id} updated", 200);
    
});

$app->delete('delete-comment/{id}.{format}', function($id) use($app){
    
    $sql = Comment::find($id);
    
    $comment = $app['db']->fetchAll($sql);
    
    
    if(empty($comment))
    {
        return new Response('Comment not found.', 404);
    }
    
    $sql = Comment::getDeleteSQL($id);
    
    $app['db']->exec($sql);

    return new Response("Comment with ID: {$id} deleted", 200);
    
}); 

return $app;