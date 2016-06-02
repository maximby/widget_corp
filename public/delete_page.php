<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

find_selected_page();
$current_page = find_page_by_id($_GET['page']);
if (!$current_page) {
    redirect_to('manage_content.php');
}
ob_start();
include __DIR__ . '/../includes/layouts/header.php';
$id = $current_page['id'];


$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message']  = "Page deleted.";
    redirect_to('manage_content.php');
} else {
    $_SESSION['message']  = "Page deleted failed.";
    redirect_to('manage_content.php?subject='.$id);
}
ob_end_flush();