<!doctype html>

<?php
    // Ensures there is always a value for $page_title
    if(!isset($page_title)):
        $page_title = "Generic 'Staff Area' Title";
    endif;
?>

<html lang="en">
  <head>
    <title>GBI - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <!-- Down below, "href" is dealing with the browser -->
    <link rel="stylesheet" media="all" href= "<?php echo url_for("/stylesheets/staff.css"); ?>" />
  </head>

  <body>

      <header>
          <h1>GBI Staff Area</h1>
      </header>

      <navigation>
          <ul>
              <li> <a href = "<?php echo url_for("staff/index.php"); ?>" >Menu</a> </li>
          </ul>
      </navigation>
