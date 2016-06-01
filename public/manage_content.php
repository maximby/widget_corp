<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

$query = 'SELECT * ';
$query .= 'FROM subjects ';
$query .= 'WHERE visible = 1 ';
$query .= 'ORDER BY position ASC';
$result = mysqli_query($connection, $query);
confirm_query($result);

include __DIR__ . '/../includes/layouts/header.php' ?>
    <div id="main">
        <div id="navigator">
           <ul class="subjects">
           <?php
             while ($subject = mysqli_fetch_assoc($result)):
           ?>
               <li><?php echo $subject['menu_name'] . ' (' . $subject['id'] . ')';?></li>
           <?php endwhile; ?>
           </ul>

        </div> <!-- navigator -->
        <div id="page">
            <h2>Manage Content</h2>

        </div> <!-- page -->
    </div> <!--main -->
<?php
mysqli_free_result($result);
include __DIR__ . '/../includes/layouts/footer.php'
?>