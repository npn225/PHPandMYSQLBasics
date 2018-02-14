<footer>
    &copy; <?php echo date('Y'); ?> Globe Bank
</footer>

</body>
</html>

<?php

    // Makes sure to close the database at the
    // end of every PHP page
    db_disconnect($db);

?>
