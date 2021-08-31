<?php
setlocale ("LC_TIME", "ru_RU");

require_once 'config_private.php';

// DB connection
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$mysqli->set_charset("utf8");