<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
ob_start();
$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php';

if (!$_GET['subject']) {
    redirect_to('manage_content.php');
}
find_selected_page();
?>

<div id="main">
    <div id="navigator">
        <?php echo navigation($current_page, $current_page); ?>
    </div>
    <div id="page">
        <?php echo message();
        $errors = errors();
        echo form_errors($errors)?>
        <h2>Create Page</h2>

        <form action="create_page.php" method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="" />
            </p>
            <p>Position:
                <select name="position">
                    <?php
                    $page_set = find_pages_for_subjects($_GET['subject']);
                    $page_count = mysqli_num_rows($page_set);
                    for($count=1; $count <= ($page_count + 1); $count++) {
                        echo "<option value=\"{$count}\">{$count}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" /> No
                &nbsp;
                <input type="radio" name="visible" value="1" /> Yes
            </p>
            <p>Content:<br/>
                <textarea rows="17" cols="90" name="content"></textarea>
            </p>
            <input type="hidden" name="subject_id" value="<?php echo $_GET['subject']?>">
            <input type="submit" name="submit" value="Create Page" />
        </form>
        <br />
        <a href="manage_content.php">Cancel</a>
    </div>
</div>
<?php
ob_end_flush();
include("../includes/layouts/footer.php");
