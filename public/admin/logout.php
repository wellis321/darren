<?php
require_once dirname(__DIR__, 2) . '/config/session.php';
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
