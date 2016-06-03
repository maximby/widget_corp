<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';


if (!$current_admin = find_admin_by_id($_GET['admin'])) {
    redirect_to('manage_admins.php');
}
ob_start();
if (isset($_POST['submit'])) {

    $username = mysql_prep($_POST['username']);
    $password = mysql_prep($_POST['password']);

    // validation
    $required_fields = ['username', 'password'];
    validate_presence($required_fields);

    $fields_with_max_lengths = ['username' => 30];
    validate_max_lengths($fields_with_max_lengths);


    if (empty($errors)){

        $id =$current_admin['id'];
        $query = "UPDATE admins SET " ;
        $query .= "  username ='{$username}', hashed_password ='{$password}'";
        $query .= " WHERE id = $id";
        $query .= " LIMIT 1";
      // echo $query; die;
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION['message']  = "Admin updated.";
            redirect_to('manage_admins.php');
        } else {
            $message = "Admin updated failed.";

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
            $errors = errors();
            echo form_errors($errors)?>
        <h2>Create Page</h2>

        <form action="edit_admin.php?admin=<?php echo  urlencode($current_admin['id'])?>" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo $current_admin['username']?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>

            <input type="submit" name="submit" value="Create Admin" />
        </form>
        <br />
        <a href="manage_content.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_admin.php?page=<?php echo  urlencode($current_admin['id']) ?>"
           onclick="return confirm('Вы уверены?');" >Deleted admin</a>
    </div>
</div>

<?php
ob_end_flush();
include("../includes/layouts/footer.php"); ?>

