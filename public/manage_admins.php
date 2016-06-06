<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';
confirm_logged_in();
$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php';


?>

    <div id="main">
        <div id="navigator">
            <br/>
            <a href="admin.php">&laquo; Main menu</a>
        </div> <!-- navigator -->
        <div id="page">
            <?php echo message();?>
                <h2>Manage Admins</h2>
                <table style="min-width: 300px">
                    <tr style="text-align: left">
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $admin_set = find_all_admins();
                    while ($admin = mysqli_fetch_assoc($admin_set)): ?>
                    <tr>
                        <td><?php echo $admin['username'] .' -> '. $admin['hashed_password']?></td>
                        <td><a href="edit_admin.php?admin=<?= urlencode($admin['id'])?>">Edit</a>  <a href="delete_admin.php?admin=<?= urlencode($admin['id'])?>"  onclick="return confirm('Вы уверены?');">Delete</a></td>
                    </tr>
                    <?php endwhile; ?>
                </table>

                <br/><br/>
                <a href="new_admin.php">Add new admin</a>
                <br/><br/>
        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>