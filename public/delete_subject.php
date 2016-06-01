<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

find_selected_page();
$current_subject = find_subject_by_id($_GET['subject']);
if (!$current_subject) {
    redirect_to('manage_content.php');
}
ob_start();
include __DIR__ . '/../includes/layouts/header.php';
$id = $current_subject['id'];

$pages_set = find_pages_for_subjects($id);
if (mysqli_num_rows($pages_set) > 0) {
    $_SESSION["message"] = "Can't delete a subject with pages.";
    redirect_to("manage_content.php?subject={$current_subject["id"]}");
}


$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message']  = "Subject deleted.";
    redirect_to('manage_content.php');
} else {
    $_SESSION['message']  = "Subject deleted failed.";
    redirect_to('manage_content.php?subject='.$id);
}
ob_end_flush();