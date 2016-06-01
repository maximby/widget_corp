<?php
ini_set('display_errors','On');
error_reporting('E_ALL');

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
include __DIR__ . '/../includes/layouts/header.php';

if (isset($_GET['subject'])) {
    $selected_subject_id = $_GET['subject'];
    $selected_page_id = null;
} elseif (isset($_GET['page'])) {
    $selected_page_id = $_GET['page'];
    $selected_subject_id = null;
} else {
    $selected_subject_id = null;
    $selected_page_id = null;
}
?>

    <div id="main">
        <div id="navigator">
            <?php echo navigation($selected_subject_id, $selected_page_id) ?>
        </div> <!-- navigator -->
        <div id="page">
            <h2>Manage Content</h2>
            <?php echo $selected_subject_id;?> <br />
            <?php echo $selected_page_id;?>

        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>