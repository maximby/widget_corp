<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
include __DIR__ . '/../includes/layouts/header.php';

find_selected_page();
 ?>

    <div id="main">
        <div id="navigator">
            <br/>
            <a href="admin.php">&laquo; Main menu</a>
            <?php echo navigation($current_subject, $current_page) ?>
            <br />
            <a href="new_subject.php">Add a subject</a>
        </div> <!-- navigator -->
        <div id="page">
            <?php
            echo message();
            if ($current_subject) {?>
                <h2>Manage Subject</h2>
             <?php echo "Menu name: " . htmlentities($current_subject['menu_name']) ?>
                <br/>
                Position: <?php echo $current_subject['position'] ?><br/>
                Visible: <?php echo $current_subject['visible']? 'true':'false' ?><br/>
                <a href="edit_subject.php?subject=<?php echo urlencode($current_subject['id']);?>">Edit Subject</a>
                <?php
            } elseif ($current_page) {?>
                <h2>Manage Page</h2>
                 <?php

                echo "Menu name: " . htmlentities($current_page['menu_name']);?>
                <br/>
                Position: <?php echo $current_page['position'] ?><br/>
                Visible: <?php echo $current_page['visible']? 'true':'false' ?><br/>
                Content: <?php echo htmlentities($current_page['content']) ?><br/>
              <?php
            } else {
                 echo "Выберите объект или страницу";
            }
            ?>

        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>