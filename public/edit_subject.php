<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
find_selected_page();
 if (!$current_subject) {
     redirect_to('manage_content.php');
 }
ob_start();
if (isset($_POST['submit'])) {

    $menu_name = mysql_prep($_POST['menu_name']);
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];

    // validation
    $required_fields = ['menu_name', 'position', 'visible'];
    validate_presence($required_fields);

    $fields_with_max_lengths = ['menu_name' => 30];
    validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)){

        $id =$current_subject['id'];
        $query = "UPDATE subjects SET " ;
        $query .= " menu_name ='{$menu_name}', position = $position , visible = $visible ";
        $query .= " WHERE id = $id";
        $query .= " LIMIT 1";
       // echo $query;
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION['message']  = "Subject updated.";
            redirect_to('manage_content.php');
        } else {
            $message = "Subject updated failed.";

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
        <?php echo navigation($current_subject, $current_page); ?>
    </div>
    <div id="page">
        <?php
        if (!empty($message)) {
            echo "<div class='message'>" . htmlentities($message) . "</div>";
        }
        //$errors = errors();
        echo form_errors($errors)?>
        <h2>Edit Subject: <?php echo $current_subject['menu_name'] ?></h2>

        <form action="edit_subject.php?subject=<?php echo urlencode($current_subject['id']) ?>" method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="<?php echo $current_subject['menu_name'] ?>" />
            </p>
            <p>Position:
                <select name="position" >
                    <?php
                    $subject_set = find_all_subjects(false);
                    $subject_count = mysqli_num_rows($subject_set);
                    for($count=1; $count <= $subject_count; $count++) {
                        echo "<option value=\"{$count}\"";
                        if ($current_subject['position'] == $count){
                            echo " selected";
                        }

                        echo ">{$count}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" <?php if($current_subject['visible'] == 0){
                    echo " checked";} ?> /> No
                &nbsp;
                <input type="radio" name="visible" value="1" <?php if($current_subject['visible'] == 1){
                    echo " checked";} ?> /> Yes
            </p>
            <input type="submit" name="submit" value="Edit Subject" />
        </form>
        <br />
        <a href="manage_content.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_subject.php?subject=<?php echo  urlencode($current_subject['id']) ?>"
           onclick="return confirm('Вы уверены?');" >Deleted subject</a>
    </div>
</div>

<?php
ob_end_flush();
include("../includes/layouts/footer.php"); ?>

