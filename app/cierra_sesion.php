<?php
require_once __DIR__ . "/app_security.php";

app_clear_auth_cookies();
header('Location: login.php');
?>