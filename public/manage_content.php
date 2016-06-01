<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

$query = 'SELECT * ';
$query .= 'FROM subjects ';
$query .= 'WHERE visible = 1 ';
$query .= 'ORDER BY position ASC';
$subject_set = mysqli_query($connection, $query);
confirm_query($subject_set);

include __DIR__ . '/../includes/layouts/header.php' ?>
    <div id="main">
        <div id="navigator">
           <ul class="subjects">
           <?php
             while ($subject = mysqli_fetch_assoc($subject_set)):
           ?>
               <li><?php echo $subject['menu_name'] ;

                       $query = 'SELECT * ';
                       $query .= 'FROM pages ';
                       $query .= 'WHERE visible = 1 ';
                       $query .= 'AND subject_id = ' . $subject['id'];
                       $query .= ' ORDER BY position ASC';
                       $pages_set = mysqli_query($connection, $query);
                       confirm_query($pages_set);

                   ?>
                   <ul class="pages">
                       <?php while ($pages = mysqli_fetch_assoc($pages_set)):?>
                     <li><?php echo $pages['menu_name']?></li>
                    <?php
                        endwhile;
                       mysqli_free_result($pages_set);
                    ?>
                   </ul>
               </li>
           <?php
             endwhile;
             mysqli_free_result($subject_set);
           ?>
           </ul>

        </div> <!-- navigator -->
        <div id="page">
            <h2>Manage Content</h2>

        </div> <!-- page -->
    </div> <!--main -->
<?php
include __DIR__ . '/../includes/layouts/footer.php'
?>