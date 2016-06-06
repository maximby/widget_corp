<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
ob_start();
if (isset($_POST['submit'])) {
    $subject_id = (int) $_POST['subject_id'];
    //var_dump($subject_id);die;
    $menu_name = mysql_prep($_POST['menu_name']);
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];
    $content = mysql_prep($_POST['content']);

    // validation
    $required_fields = ['menu_name', 'position', 'visible', 'content'];
    validate_presence($required_fields);

    $fields_with_max_lengths = ['menu_name' => 30];
    validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to('new_page.php');
        die;
    }

    $query = "INSERT INTO pages (";
    $query .= "subject_id, menu_name, position, visible, content ";
    $query .= ")";
    $query .= "VALUES (";
    $query .= " {$subject_id},'{$menu_name}', {$position}, {$visible}, '{$content}'  ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['message']  = "Page created.";
        redirect_to('manage_content.php');
    } else {
        $_SESSION['message'] = "Page created failed.";
        redirect_to('new_page.php');
    }


} else {
    // запрос был GET
    redirect_to('new_page.php');
}
ob_end_flush();