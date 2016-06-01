<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'widget_cms');
define('DB_PASS', 'ctrhtn');
define('DB_NAME', 'widget_corp');

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_error()) {
    die('Ошибка соединения с БД: '.
        mysqli_connect_error() .
        ' (' . mysqli_connect_errno() . ')'
    );
}
