<?php

// This guide demonstrates the five fundamental steps
// of database interaction using PHP.

// Credentials
$dbhost = "localhost";
$dbuser = "nnamdi";
$dbpass = "master";
$dbname = "globe_bank";

// STEP 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Test if connection succeeded
if (mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " (" . mysqli_connect_errno() . ')';
    exit($msg);
}



// STEP 2. Perform database query
$query = "SELECT * FROM subjects;"; // Just any random MySQL $query
// "mysqli_query" returns true/false for CREATE, UPDATE, and DELETE queries
// "mysqli_query" returns a "result_set" for a SELECT query
$result_set = mysqli_query($connection, $query);

// Test if query succeeded
if (!$result_set) {
    $msg = "Database query failed!<br/>";
    $msg .= "FAILED QUERY: \"" . $query . "\"<br/>";
    exit($msg);
}



// STEP 3. Use returned data (if any)
// Below loops through all the rows in the table in "result_set"
// "mysqli_fetch_assoc()" automatically advances the pointer in the result_set
while ($subject = mysqli_fetch_assoc($result_set)) {
    echo $subject["menu_name"] . "<br/>";
}



// STEP 4. Release returned data
// "mysqli_free_result" frees up memory space and should always
// be called after "mysqli_query" for good memory management
mysqli_free_result($result_set);



// STEP 5. Close database connection
mysqli_close($connection);

?>
