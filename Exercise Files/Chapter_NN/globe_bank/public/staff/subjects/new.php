<?php
    // There can be NO whitespace before or after the php-tag
    // since we are dealing with html headers
    require_once("../../../private/initialize.php");

    // If statement below makes sure that the only way
    // to access this page is by submitting the form -
    // through POST request instead of GET request
    if (is_post_request()) {
        // Handle form values sent by new.php

        $subject = [];
        $subject["menu_name"] = $_POST['menu_name'] ?? '';
        $subject["position"] = $_POST['position'] ?? '';
        $subject["visible"] = $_POST['visible'] ?? '';

        $result = insert_subject($subject);

        if ($result === true) {
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for("/staff/subjects/show.php?id=" . $new_id));
        } else {
            $errors = $result;
        }

    } else {
        // Display the black form
    }

    // Initialize all necessary variables
    $id = $_GET["id"] ?? "";

    $subject_set = find_all_subjects();
    // One added to count below to account for NEW subject being created
    $subject_count = mysqli_num_rows($subject_set) + 1;
    mysqli_free_result($subject_set);

    $subject = [];
    // Position of new subject would just be the maximum position number
    $subject["position"] = $subject_count;
?>

<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject new">
    <h1>Create Subject</h1>

    <?php echo display_errors($errors) . "<br/>"; ?>

    <!-- action allows us to submit values from the form
         to a specified php page. -->
    <form action="<?php echo url_for("/staff/subjects/new.php"); ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php
                // The number of positions should be equal
                // to the number of pages in the page table
                for($index = 1; $index <= $subject_count; ++$index) :
                    echo "<option value = \"{$index}\" ";
                    if ($subject["position"] == $index) :
                        echo "selected";
                    endif;
                    echo ">{$index}</option>";
                endfor;
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <!-- Hidden below allows visible to still have an
               actual value if checkbox is not checked!  -->
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Subject" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
