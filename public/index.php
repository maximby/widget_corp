<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

$layout_context = 'public';
include __DIR__ . '/../includes/layouts/header.php';

find_selected_page(true);
?>

    <div id="main">
        <div id="navigator">
            <br/>
            <a href="admin.php">&laquo; Main menu</a>
            <?php echo public_navigation($current_subject, $current_page) ?>

        </div> <!-- navigator -->
        <div id="page">
            <?php
             if ($current_page) {
                 echo '<h2>' . htmlentities($current_page['menu_name']) . '</h2>'  ;
                 echo nl2br(htmlentities($current_page['content']))  ;
            } else {
               echo '<p>Welcome!</p>';
            }
            ?>

        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>