<?php
    ob_start(); // Output Buffering is turned on

    // Assign file paths to PHP constants
    // __FILE__ returns the current path to this file
    // dirname() returns the path to the parent directory
    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');

    // Assign the root URL to a PHP constant
    // * Do not need to include the domain
    // * Use same document root as webserver
    // * Can set a hardcoded value:
    // define("WWW_ROOT", '/~kevinskoglund/globe_bank/public');
    // define("WWW_ROOT", '');
    // * Can dynamically find everything in URL up to "/public"
    // strpos() + 7 - Gets the position of letter 'c' in /public
    // substr() - Gets path from "C:" to "/public"
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    $doc_root = str_replace(' ', "%20", $doc_root); // Needed for space in "Exercise Files"
    define("WWW_ROOT", $doc_root);

    require_once("functions.php");
    require_once("query_functions.php");
    require_once("database.php");
    require_once("validation_functions.php");

    // Makes sure every PHP page that loads this page
    // has access to the database functions and database definitions
    $db = db_connect();
    $errors = []; // Used to handle user errors for data validation
?>
