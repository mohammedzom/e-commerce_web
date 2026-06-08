<?php
require __DIR__ . "/../config/variables.php";
session_start();
session_unset();
session_destroy();
header("Location: " . APPURL . "index.php");
exit;
