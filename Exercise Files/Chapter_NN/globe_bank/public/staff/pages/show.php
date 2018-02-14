<?php

    // This entire page is part of Ch2 Challenge

    require_once("../../../private/initialize.php");

    include(SHARED_PATH . "/staff_header.php");

    $id = $_GET["id"] ?? 1;

    $page = find_page_by_id($id);

    $page_title = "GBI - Staff Show Page";
?>

<div id="content">

    <a href="./index.php"><?php echo "&laquo; Back to List<br/>"; ?></a>

    <div class="page_show">
        <h1>Page: <?php echo h($page["menu_name"]); ?></h1>

        <div class="attributes">
            <dl class="">
                <dt>Menu Name</dt>
                <dd><?php echo h($page["menu_name"]); ?></dd>
            </dl>
            <dl class="">
                <dt>Subject</dt>
                <dd><?php echo h(find_subject_name($page["subject_id"])); ?></dd>
            </dl>
            <dl class="">
                <dt>Position</dt>
                <dd><?php echo h($page["position"]); ?></dd>
            </dl>
            <dl class="">
                <dt>Visible</dt>
                <dd><?php echo $page["visible"] == '1' ? "true" : "false"; ?></dd>
            </dl>
            <dl class="">
                <dt>Content</dt>
                <dd><?php echo h($page["content"]); ?></dd>
            </dl>
        </div>
    </div>

</div>

<?php include(SHARED_PATH . "/staff_footer.php"); ?>
