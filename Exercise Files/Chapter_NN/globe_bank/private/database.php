<?php
    // This PHP file is the place where all the functions
    // related to the database get stored

    require_once("db_credentials.php");

    function confirm_db_connect() {
        // Tests to make sure no errors or problems
        // arose while trying to connect to the database
        if (mysqli_connect_errno()) {
            $msg = "Database connection failed: ";
            $msg .= mysqli_connect_error();
            $msg .= " (" . mysqli_connect_errno() . ')';
            exit($msg);
        }
    }

    function db_connect() {
        // Handles all the business of connecting us to
        // the database
        $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        confirm_db_connect();
        return $connection;
    }

    function db_disconnect($connection) {
        // Closes the database connection
        if (isset($connection)) :
            mysqli_close($connection);
            // Below line confirms database connection is closed
            // echo "CONNECTION CLOSED!<br/>";
        endif;
    }

    function confirm_query_result_set($result_set, $query) {
        // Checks to make sure that the query actually succeeded
        if (!$result_set) {
            $msg = "Database query failed!<br/>";
            $msg .= "FAILED QUERY: \"" . $query . "\"<br/>";
            exit($msg);
        }
    }

    function db_escape($connection, $string) {
        // Converts any text that is special to SQL into
        // plaintext equivalent
        // Helps prevent SQL injection
        return mysqli_real_escape_string($connection, $string);
    }

?>
