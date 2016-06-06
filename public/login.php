<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

ob_start();
$username = '';
if (isset($_POST['submit'])) {
  // validation
    $required_fields = ['username', 'password'];
    validate_presence($required_fields);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($errors)){
        $found_admin = attempt_login($username, $password);
        if ($found_admin) {

            $_SESSION["admin_id"] = $found_admin["id"];
            $_SESSION["username"] = $found_admin["username"];
            redirect_to("admin.php");
        } else {
            // Failure
            $_SESSION["message"] = "Username/password not found.";
        }
    }
} else {
    // запрос был GET
} // end: if (isset($_POST['submit']))

$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php';
?>
<div id="main">
    <div id="navigator">
        <br/>
        <a href="admin.php">&laquo; Main menu</a>
    </div>
    <div id="page">

        <?php echo message();
        //$errors = errors();
        echo form_errors($errors)?>
        <h2>Login</h2>

        <form action="login.php" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($username)?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>

            <input type="submit" name="submit" value="Submit " />
        </form>
           </div>
</div>

<?php
ob_end_flush();
include("../includes/layouts/footer.php"); ?>

