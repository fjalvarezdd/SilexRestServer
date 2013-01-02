<?php

/**
 * Walk array recursively and applies the function to each item utf8_encode
 * @param array $array
 * @return array
 */
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        $item = utf8_encode($item);
    });
    
    return $array;
}