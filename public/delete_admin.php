<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

if (!$current_admin = find_admin_by_id($_GET['admin'])) {
    redirect_to('manage_admins.php');
}
ob_start();
include __DIR__ . '/../includes/layouts/header.php';
$id = $current_admin['id'];


$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message']  = "Admin deleted.";
    redirect_to('manage_admins.php');
} else {
    $_SESSION['message']  = "Admin deleted failed.";
    redirect_to('manage_admins.php');
}
ob_end_flush();