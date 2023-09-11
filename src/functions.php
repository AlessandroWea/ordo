<?php

function dd($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function redirect(string $path)
{
    header('Location: /'.$path);
    exit();
}

function post($key, $default = '')
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}