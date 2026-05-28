<?php
session_start();
function checkLogin(): bool
{
    return !empty($_SESSION['user_id']);
}

function checkIsAdmin(): bool
{
    if (checkLogin()) {
        return $_SESSION['role'] == 'admin';
    }

    return false;
}
