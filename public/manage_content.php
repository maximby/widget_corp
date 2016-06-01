<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db_connection.php';

include __DIR__ . '/../includes/layouts/header.php' ?>
    <div id="main">
        <div id="navigator">
           <ul class="subjects">
           <?php
           $subject_set = find_all_subjects();
             while ($subject = mysqli_fetch_assoc($subject_set)):
           ?>
               <li><?php echo $subject['menu_name'] ;
                       $pages_set = find_pages_for_subjects($subject['id'])
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