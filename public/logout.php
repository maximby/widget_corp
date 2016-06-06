<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

$_SESSION['admin_id'] = null;
$_SESSION['username'] = null;
redirect_to('login.php');
