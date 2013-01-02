<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


require_once (BASE_DIR . '/src/config.php');
require_once (BASE_DIR . '/src/bootstrap.php');
require_once (BASE_DIR . '/src/util.php');
$app = require(BASE_DIR . '/src/controllers.php');


/**
  * This method runs before any action defined in the
  * Src / controllers.php
  *
  * In this case handles authentication using "HTTP Basic Authentication"
  * If you have not received your username and password correctly
  * Returns the error code 403 - Unauthorized. In case of not wanting to control
  * Service using a username and password could comment on the content
  * This method.
  */
$app->before(function (Request $request) use ($app){
    
    $user = $request->server->get('PHP_AUTH_USER');
    $pass = $request->server->get('PHP_AUTH_PW');
    
    if($app['auth.user'] != $user || $app['auth.pass'] != $pass)
    {
        return new Response('Unauthorized', 403, array('WWW-Authenticate' => 'Basic realm="Authentication required"'));
    }
    
});

/**
  * This method is executed after any action defined in the
  * src/controllers.php
  *
  * Controls the extension (format) that we use when requesting a URL to return
  * The most appropriate content type. In the chaos of an extension is not defined correctly
  * Return error code 404 - Page not existing.
  */
$app->after(function(Request $request, Response $response) use ($app){
    
    $format = $request->get('format');
    
    switch($format)
    {
        case 'json' :
            $response->headers->set('Content-Type', 'application/json');
            break;
        case 'xml' :
            $response->headers->set('Content-Type', 'application/xml');
            break;
        case 'html' :
            $response->headers->set('Content-Type', 'text/html');
            break;
        default:
            $app->abort(404, "Format '{$format}' is not available");
    }
    
});


/**
  * This method manages the place errors will not
  * Managed and controlled by us as a general catch.
  */
$app->error(function(\Exception $e, $code) use($app){
    
    if ($app['debug'])
        return ;
    
    switch($code)
    {
        case 404:
            $message = 'The page you are looking for does not exist.';
            break;
        default:
            $message = 'An error has occurred while processing your request.';
            break;
    }

    return new Response($message, $code);
    
});

return $app;