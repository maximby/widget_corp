<?php

function redirect_to($new_location) {
    header("location: " . $new_location);
    exit;
}

function mysql_prep($string) {
    global $connection;
    return  mysqli_real_escape_string($connection, $string);
}

function confirm_query($result_set)
{
    if (!$result_set) {
        die("Запрос к БД невыполнен");
    }
}

// Поиск всех объектов
function find_all_subjects($public = true)
{
    global $connection;
    $query = 'SELECT * ';
    $query .= 'FROM subjects ';
    if ($public){
        $query .= 'WHERE visible = 1 ';
    }
    $query .= 'ORDER BY position ASC';
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
    return $subject_set;
}

// Поиск всех страниц
function find_all_pages_for_subject()
{
    global $connection;
    $query = 'SELECT * ';
    $query .= 'FROM pages ';
   // $query .= 'WHERE visible = 1 ';
    $query .= 'ORDER BY position ASC';
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
    return $subject_set;
}

// Поиск всех страниц для объекта
function find_pages_for_subjects($subject_id, $public=true)
{
    global $connection;
    $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

    $query = 'SELECT * ';
    $query .= 'FROM pages ';
    $query .= 'WHERE  subject_id = ' . $safe_subject_id;
    if ($public) {
        $query .= ' AND visible = 1 ';
    }

    $query .= ' ORDER BY position ASC';
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    return $page_set;
}

// Найти объект по id
function find_subject_by_id($subject_id, $public = true) {
    global $connection;

    $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
    $query = 'SELECT * ';
    $query .= 'FROM subjects ';
    $query .= 'WHERE  id = ' . $safe_subject_id;
     if ($public) {
         $query .= ' AND visible = 1 ';
     }
    $query .= ' LIMIT 1';
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
    if ($subject = mysqli_fetch_assoc($subject_set)) {
        return $subject;
    } else {
        null;
    }
}

// Найти страницу по id
function find_page_by_id($page_id, $public=true) {
    global $connection;

    $safe_page_id = mysqli_real_escape_string($connection, $page_id);
    $query = 'SELECT * ';
    $query .= 'FROM pages ';
    $query .= 'WHERE  id = ' . $safe_page_id;
    if ($public) {
        $query .= ' AND visible = 1';
    }
    $query .= ' LIMIT 1';
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    if ($page = mysqli_fetch_assoc($page_set)) {
        return $page;
    } else {
        null;
    }

}

function find_default_page_for_subject($subject_id) {
    $page_set = find_pages_for_subjects($subject_id);
    if($first_page=mysqli_fetch_assoc($page_set)) {
        return $first_page;
    } else {
        return null;
    }
}

function find_selected_page($public = false) {
    global $current_subject;
    global $current_page;

    if (isset($_GET['subject'])) {
        $current_subject = find_subject_by_id($_GET['subject'], $public);
        if($current_subject && $public) {
            $current_page =find_default_page_for_subject($current_subject['id']);
        } else {
            $current_page = null;
        }

    } elseif (isset($_GET['page'])) {
        $current_page = find_page_by_id($_GET['page'], $public);
        $current_subject = null;
    } else {
        $current_page = null;
        $current_subject = null;
    }

}

function find_all_admins() {
    global $connection;
    $query = 'SELECT * ';
    $query .= 'FROM admins ';
    $query .= 'ORDER BY username ASC';
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    return $admin_set;
}


function find_admin_by_id($admin_id) {
    global $connection;

    $admin_id = (int) $admin_id;
    $query = 'SELECT * ';
    $query .= 'FROM admins ';
    $query .= 'WHERE  id = ' . $admin_id;
    $query .= ' LIMIT 1';
    //echo $query;die;
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    if ($admin = mysqli_fetch_assoc($admin_set)) {
        return $admin;
    } else {
        null;
    }
}

function find_admin_by_username($username) {
    global $connection;

    $username = mysql_prep($username);
    $query = 'SELECT * ';
    $query .= 'FROM admins ';
    $query .= "WHERE  username = '{$username}'";
    $query .= ' LIMIT 1';
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    if ($admin = mysqli_fetch_assoc($admin_set)) {
        return $admin;
    } else {
        null;
    }
}



// Навигация принимает 2 аргумент
// текущий выбранный  subject array or null
// и текущей страницы array or null

function navigation($subject_array, $page_array)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects(false);
    while ($subject = mysqli_fetch_assoc($subject_set)):
        $output .= "<li ";
        if ($subject_array && $subject['id'] == $subject_array['id']) {
            $output .= "class=\"selected\"";
        }
        $output .= " >";
        $output .= "<a href=\"manage_content.php?subject=";
        $output .= urldecode($subject['id']);
        $output .= '">';
        $output .= $subject['menu_name'];
        $output .= "</a>";
        $output .= "<ul class=\"pages\">";
        $pages_set = find_pages_for_subjects($subject['id'], false );
        while ($page = mysqli_fetch_assoc($pages_set)):
            $output .= "<li ";
            if ($page_array && $page['id'] == $page_array['id']) {
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


function public_navigation($subject_array, $page_array)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects();
    while ($subject = mysqli_fetch_assoc($subject_set)):
        $output .= "<li ";
        if ($subject_array  && $subject['id'] == $subject_array['id']) {
            $output .= "class=\"selected\"";
        }
        $output .= " >";
        $output .= "<a href=\"index.php?subject=";
        $output .= urldecode($subject['id']);
        $output .= '">';
        $output .= $subject['menu_name'];
        $output .= "</a>";


        if ($subject['id'] == $subject_array['id'] || $subject['id'] == $page_array['subject_id']) {
            $output .= "<ul class=\"pages\">";
            $pages_set = find_pages_for_subjects($subject['id']);
            while ($page = mysqli_fetch_assoc($pages_set)):
                $output .= "<li ";
                if ($page_array && $page['id'] == $page_array['id']) {
                    $output .= "class=\"selected\"";
                };
                $output .= "\" >";
                $output .= "<a href=\"index.php?page=";
                $output .= urldecode($page['id']);
                $output .= "\">";
                $output .= $page['menu_name'];
                $output .= "</a>";
                $output .= "</li>";

            endwhile;
            mysqli_free_result($pages_set);
            $output .= "</ul>";
        }

        $output .= "</li>";
    endwhile;
    mysqli_free_result($subject_set);
    $output .= "</ul>";
    return $output;
}

function general_salt($length) {
    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '.', $base64_string);
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

function password_encrypt($password) {
    $hash_format = '$2y$11$';
    $salt_length = 22;
    $salt = general_salt($salt_length);
    $format_and_salt = $hash_format.$salt;

    $hash = crypt($password, $format_and_salt);
   return $hash;
}

function password_check($password, $hash) {
    return crypt($password, $hash) === $hash;
}

function attempt_login($username, $password) {
    $admin = find_admin_by_username($username);
    if($admin) {
        if (password_check($password, $admin['hashed_password'])) {
            return $admin;
        } else {
            return false;
        }

    } else {
        return false;
    }

}
function logged_in() {
   return isset($_SESSION['admin_id']);
}
function confirm_logged_in() {
    if (!logged_in()){
        redirect_to('login.php');
    }
}