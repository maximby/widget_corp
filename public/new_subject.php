<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php';

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
        <h2>Create Subject</h2>

        <form action="create_subject.php" method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="" />
            </p>
            <p>Position:
                <select name="position">
                    <?php
                    $subject_set = find_all_subjects();
                    $subject_count = mysqli_num_rows($subject_set);
                    for($count=1; $count <= ($subject_count + 1); $count++) {
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
            <input type="submit" name="submit" value="Create Subject" />
        </form>
        <br />
        <a href="manage_content.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
