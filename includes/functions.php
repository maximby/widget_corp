<?php

function confirm_query($result_set)
{
    if (!$result_set) {
        die("Запрос к БД невыполнен");
    }
}

// Поиск всех объектов
function find_all_subjects()
{
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
function find_pages_for_subjects($subject_id)
{
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

// Навигация принимает 2 аргумента
// текущий выбранный id subject
// и id текущей страницы
function navigation($subject_id, $page_id)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects();
    while ($subject = mysqli_fetch_assoc($subject_set)):
        $output .= "<li ";
        if ($subject['id'] == $subject_id) {
            $output .= "class=\"selected\"";
        }
        $output .= " >";
        $output .= "<a href=\"manage_content.php?subject=";
        $output .= urldecode($subject['id']);
        $output .= '">';
        $output .= $subject['menu_name'];
        $output .= "</a>";
        $output .= "<ul class=\"pages\">";
        $pages_set = find_pages_for_subjects($subject['id']);
        while ($page = mysqli_fetch_assoc($pages_set)):
            $output .= "<li ";
            if ($page['id'] == $page_id) {
                $output .= "class=\"selected\"";
            };
            $output .= "\" >";
            $output .= "<a href=\"manage_content.php?page=";
            $output .= urldecode($page['id']);
            $output .= "\">";
            $output .= $page['menu_name'];
            $output .= "</a>";
            $output .= "</li>";

        endwhile;
        mysqli_free_result($pages_set);
        $output .= "</ul></li>";

    endwhile;
    mysqli_free_result($subject_set);
    $output .= "</ul>";
    return $output;
}