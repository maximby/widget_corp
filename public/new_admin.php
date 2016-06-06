<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
ob_start();
$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php';


find_selected_page();
?>

    <div id="main">
        <div id="navigator">
            <br/>
            <a href="admin.php">&laquo; Main menu</a>

        </div> <!-- navigator -->
        <div id="page">
            <?php echo message();
            $errors = errors();
            echo form_errors($errors)?>
            <h2>Create Page</h2>

            <form action="create_admin.php" method="post">
                <p>Username:
                    <input type="text" name="username" value="" />
                </p>
                 <p>Password:
                    <input type="password" name="password" value="" />
                </p>

                <input type="submit" name="submit" value="Create Admin" />
            </form>
            <br />
            <a href="manage_admins.php">Cancel</a>
        </div>
    </div>
<?php
ob_end_flush();
include("../includes/layouts/footer.php");
