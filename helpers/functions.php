<?php

function hasKey(array $errors, string $key): bool
{
    return isset($errors[$key]);
}

function _safe_str($str): string
{
    return htmlspecialchars($str);
}


function _e($str): void
{
    echo _safe_str($str);
}


function getDbConnection(): mysqli
{
    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? 'root';
    $db = $_ENV['DB_NAME'] ?? 'kevin';

    
    return new mysqli($host, $user, $pass, $db);
}
