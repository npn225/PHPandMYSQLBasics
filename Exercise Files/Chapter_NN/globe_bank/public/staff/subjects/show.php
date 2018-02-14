<?php

    require_once("../../../private/initialize.php");

    include(SHARED_PATH . "/staff_header.php");

    // Below checks to see if GET["id"] was set
    // If it was set, give $id its value!  If not, give $id the value of 1
    $id = $_GET["id"] ?? 1; // Null Coalescing Operator - Only for PHP7 or greater

    $subject = find_subject_by_id($id);

    $page_title = "GBI - Staff Show Subject";


?>

<div id="content">

    <a href="./index.php"><?php echo "&laquo; Back to List<br/>"; ?></a>

    <div class="subject_show">
        <h1>Subject: <?php echo h($subject["menu_name"]); ?></h1>

        <div class="attributes">
            <dl class="">
                <dt>Menu Name</dt>
                <dd><?php echo h($subject["menu_name"]); ?></dd>
            </dl>
            <dl class="">
                <dt>Position</dt>
                <dd><?php echo h($subject["position"]); ?></dd>
            </dl>
            <dl class="">
                <dt>Visible</dt>
                <dd><?php echo $subject["visible"] == '1' ? "true" : "false"; ?></dd>
            </dl>
        </div>
    </div>

</div>

<?php include(SHARED_PATH . "/staff_footer.php"); ?>
