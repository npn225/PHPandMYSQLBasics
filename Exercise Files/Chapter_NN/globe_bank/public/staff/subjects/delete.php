<?php

    require_once('../../../private/initialize.php');

    if(!isset($_GET['id'])) {
        redirect_to(url_for('/staff/subjects/index.php'));
    }

    $id = $_GET['id'];
    $page_names = [];

    if (is_post_request()) {

        $subject = find_subject_by_id($id);
        $page_names = has_unused_subject_id($subject);

        // Only delete if this current subject's id
        // is not used by any pages
        if (empty($page_names)) {
            $result = delete_subject($id);
            redirect_to(url_for("/staff/subjects/index.php"));
        }

    } else {
        // Only need to find $subject when this
        // webpage is NOT accessed via a POST request
        $subject = find_subject_by_id($id);
    }

?>

<?php $page_title = 'Delete Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Subject</h1>

    <?php echo display_error_pages($page_names) . "<br/>"; ?>

    <p>Are you sure you want to delete this subject?</p>
    <p class="item"><?php echo h($subject['menu_name']); ?></p>

    <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
