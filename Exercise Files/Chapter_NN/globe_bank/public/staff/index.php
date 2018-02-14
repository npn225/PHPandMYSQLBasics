<!-- Always use static strings when dealing with and assigning links
    since dynamic strings can lead to security vulnerabilities -->
<!-- Cannot simplify the "require_once()" below since all the
    constants used for path simplification are located in
    the "initialize.php" file -->
<?php require_once("../../private/initialize.php"); // Working with file system here! ?>

<?php $page_title = "Staff Menu"; ?>
<?php include(SHARED_PATH . "/staff_header.php") ?>

<div id="content">
    <div id="main-menu">
        <h2>Main Menu</h2>
        <ul>
            <li><a href="<?php echo url_for("/staff/subjects/index.php"); ?>">Subjects</a></li>
            <!-- Below link to pages is part of Ch2 Challenge  -->
            <li><a href="<?php echo url_for("/staff/pages/index.php"); ?>">Pages</a></li>
        </ul>
    </div>
</div>

<?php include(SHARED_PATH . "/staff_footer.php") ?>
