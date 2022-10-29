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
