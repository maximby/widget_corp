<?php

function confirm_query($result_set) {
    if (!$result_set) {
        die("Запрос к БД невыполнен");
    }
}

// Поиск всех объектов
function find_all_subjects() {
    global $connection;
    $query = 'SELECT * ';
    $query .= 'FROM subjects ';
    $query .= 'WHERE visible = 1 ';
    $query .= 'ORDER BY position ASC';
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
    return $subject_set;
}

// Поиск всех страниц для объекта
function find_pages_for_subjects($subject_id) {
    global $connection;
    $query = 'SELECT * ';
    $query .= 'FROM pages ';
    $query .= 'WHERE visible = 1 ';
    $query .= 'AND subject_id = ' . $subject_id;
    $query .= ' ORDER BY position ASC';
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    return $page_set;
}