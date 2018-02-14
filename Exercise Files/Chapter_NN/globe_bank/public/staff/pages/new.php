<?php
    // There can be NO whitespace before or after the php-tag
    // since we are dealing with html headers
    require_once("../../../private/initialize.php");

    // If statement below makes sure that the only way
    // to access this page is by submitting the form -
    // through POST request instead of GET request
    if (is_post_request()) {
        // Handle form values sent by new.php

        $page = [];
        $page["id"] = 0; // No actual page has ID of 0
        $page["subject_id"] = $_POST["subject_id"] ?? '';
        $page["menu_name"] = $_POST["menu_name"] ?? '';
        $page["position"] = $_POST["position"] ?? '';
        $page["visible"] = $_POST["visible"] ?? '';
        $page["content"] = $_POST["content"] ?? '';

        $result = insert_page($page);

        if ($result === true) {
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for("/staff/pages/show.php?id=" . $new_id));
        } else {
            $errors = $result;
        }

    } else {
        // Display the black form
        $page = [];
        $page["page"] = "";
        $page["subject_id"] = "";
        $page["menu_name"] = "";
        $page["position"] = "";
        $page["visible"] = "";
        $page["content"] = "";
    }

    // Initialize all necessary variables
    $id = $_GET["id"] ?? "";

    $page_set = find_all_pages();
    // One added to count below to account for NEW page being created
    $page_count = mysqli_num_rows($page_set) + 1;
    mysqli_free_result($page_set);

    // Code below is for the subject_id selection process
    $subject_set = find_all_subjects();
    $subject_count = mysqli_num_rows($subject_set);
    mysqli_free_result($subject_set);

    // Position of new page would just be the maximum position number
    $page["position"] = $page_count;

?>

<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

  <div class="page new">
    <h1>Create Page</h1>

    <?php echo display_errors($errors) . "<br/>"; ?>

    <!-- action allows us to submit values from the form
         to a specified php page. -->
    <form action="<?php echo url_for("/staff/pages/new.php"); ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($page["menu_name"]); ?>" /></dd>
      </dl>
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id" >
            <?php
                // The number of positions should be equal
                // to the number of pages in the page table
                for ($index = 1; $index <= $subject_count; ++$index) :
                    echo "<option value = \"{$index}\" ";
                    echo "label = \"" . find_subject_name($index) . "\" ";
                    if ($index == 1) :
                        echo "selected";
                    endif;
                    echo ">" . find_subject_name($index) . "</option>";
                endfor;
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position" >
            <?php
                // The number of positions should be equal
                // to the number of pages in the page table
                for ($index = 1; $index <= $page_count; ++$index) :
                    echo "<option value = \"{$index}\" ";
                    if ($page["position"] == $index) :
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
          <input type="checkbox" name="visible" value="1"
          <?php echo ($page["visible"] == 1) ? "checked" : ""; ?> />
        </dd>
      </dl>
      <dl>
          <dt>Content</dt>
          <dd><textarea name="content" cols="60" rows="10"><?php echo h($page["content"]); ?></textarea></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
