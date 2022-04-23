<?php

spl_autoload_register(function ($class) {
$class = str_replace("\\","/", $class);
if (file_exists(__DIR__ .'/controllers/' . $class . '.php')) {
        include __DIR__ .'/controllers/' . $class . '.php';
    } elseif (file_exists(__DIR__ .'/models/' . $class . '.php')) {
        include __DIR__ .'/models/' . $class . '.php';
    } elseif (file_exists(__DIR__ .'/tools/' . $class . '.php')) {
        include __DIR__ .'/tools/' . $class . '.php';
    }
});