<!-- Always use static strings when dealing with and assigning links
    since dynamic strings can lead to security vulnerabilities -->
<!-- Cannot simplify the "require_once()" below since all the
    constants used for path simplification are located in
    the "initialize.php" file -->
<?php require_once("../../../private/initialize.php"); // Working with file system here! ?>

<?php

    // "find_all_subjects()" defined in private/query_functions.php
    $subject_set = find_all_subjects();

    /* The database stand-in is no longer required since were connected to a real database
    // This is a stand-in for a database
    $subjects = [
        ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'About Globe Bank'],
        ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Consumer'],
        ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Small Business'],
        ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Commercial'],
    ];
    */
?>

<?php $page_title = "Subjects"; ?>
<?php include(SHARED_PATH . "/staff_header.php") ?>

<div id="content">
    <div class="subjects listing">
      <h1>Subjects</h1>

      <div class="actions">
        <a class="action" href="<?php echo url_for("/staff/subjects/new.php");
        ?>">Create New Subject</a>
      </div>

      <table class="list">
        <tr>
          <th>ID</th>
          <th>Position</th>
          <th>Visible</th>
          <th>Name</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>

        <!-- PHP code below loops through subjects table in globe_bank database! -->
        <?php while($subject = mysqli_fetch_assoc($subject_set)) : ?>
          <tr>
            <td><?php echo h($subject['id']); ?></td>
            <td><?php echo h($subject['position']); ?></td>
            <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
            <td><?php echo h($subject['menu_name']); ?></td>
            <!-- Dynamic liks which send URL parameters to other pages -->
            <td><a class="action" href="<?php echo
            url_for("/staff/subjects/show.php?id=" . h(u($subject["id"]))); ?>">View</a></td>
            <td><a class="action" href="<?php echo
            url_for("/staff/subjects/edit.php?id=" . h(u($subject["id"]))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo
            url_for("/staff/subjects/delete.php?id=" . h(u($subject["id"]))); ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
      </table>

      <?php
        // Frees the memory by clearing all the data
        // in the $subject_set variable
        mysqli_free_result($subject_set);
      ?>

    </div>
</div>

<?php include(SHARED_PATH . "/staff_footer.php") ?>
