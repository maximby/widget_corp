<?php

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
ob_start();
if (isset($_POST['submit'])) {

    $username = mysql_prep($_POST['username']);
    $hashed_password = password_encrypt($_POST['password']);

    // validation
    $required_fields = ['username', 'password'];
    validate_presence($required_fields);

    $fields_with_max_lengths = ['username' => 30];
    validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to('new_admin.php');
        die;
    }

    $query = "INSERT INTO admins (";
    $query .= " username,  hashed_password ";
    $query .= ")";
    $query .= " VALUES (";
    $query .= " '{$username}' , '{$hashed_password}'";
    $query .= ")";
    ///echo $query;die;
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['message']  = "Admin created.";
        redirect_to('manage_admins.php');
    } else {
        $_SESSION['message'] = "Admin created failed.";
        redirect_to('new_admin.php');
    }


} else {
    // запрос был GET
  redirect_to('new_admin.php');
}
ob_end_flush();