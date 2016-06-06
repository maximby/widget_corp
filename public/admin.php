<?php
require_once __DIR__ . '/../includes/session.php';
include __DIR__ . '/../includes/functions.php' ;

confirm_logged_in();
$layout_context = 'admin';
include __DIR__ . '/../includes/layouts/header.php'
?>
    <div id="main">
        <div id="navigator">
            &nbsp;
        </div> <!-- navigator -->
        <div id="page">
            <h2>Admin Menu</h2>
            <p>Welcome to the admin area, <?php echo htmlentities($_SESSION['username'])?>.</p>
            <ul>
                <li><a href="manage_content.php">Manage Website Content</a></li>
                <li><a href="manage_admins.php">Manage Admin User</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div> <!-- page -->
    </div> <!--main -->
<?php include __DIR__ . '/../includes/layouts/footer.php' ?>