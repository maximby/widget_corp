<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
include __DIR__ . '/../includes/layouts/header.php';

find_selected_page();
 ?>

    <div id="main">
        <div id="navigator">
            <?php echo navigation($current_subject, $current_page) ?>
            <br />
            <a href="new_subject.php">Add a subject</a>
        </div> <!-- navigator -->
        <div id="page">
            <?php
            echo message();
            if ($current_subject) {?>
                <h2>Manage Subject</h2>
             <?php
                echo "Menu name: " . $current_subject['menu_name'];
            } elseif ($current_page) {?>
                <h2>Manage Page</h2>
                <?php

                echo "Menu name: " . $current_page['menu_name'];
            } else {
                 echo "Выберите объект или страницу";
            }
            ?>

        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>