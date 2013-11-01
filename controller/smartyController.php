<?php

function GeneraSmarty()
{
    if (!class_exists("Smarty"))
        require_once (dirname(__FILE__) . "/../libs/Smarty/Smarty.class.php");

    $s = new Smarty();
    $s->template_dir = dirname(__FILE__) . "/../view/tpl/";
    $s->compile_dir = dirname(__FILE__) . "/../view/compile/";
    $s->cache_dir = dirname(__FILE__) . "/../view/cache/";
    return $s;
}


    
