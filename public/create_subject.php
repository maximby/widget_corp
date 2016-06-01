<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
ob_start();
if (isset($_POST['submit'])) {

    $menu_name = mysql_prep($_POST['menu_name']);
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];

    // validation
    $required_fields = ['menu_name', 'position', 'visible'];
    validate_presence($required_fields);

    $fields_with_max_lengths = ['menu_name' => 30];
    validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to('new_subject.php');
        die;
    }

    $query = "INSERT INTO subjects (";
    $query .= "menu_name, position, visible ";
    $query .= ")";
    $query .= "VALUES (";
    $query .= " '{$menu_name}', {$position}, {$visible} ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['message']  = "Subject created.";
        redirect_to('manage_content.php');
    } else {
        $_SESSION['message'] = "Subject created failed.";
        redirect_to('new_subject.php');
    }


} else {
    // запрос был GET
    redirect_to('new_subject.php');
}
ob_end_flush();