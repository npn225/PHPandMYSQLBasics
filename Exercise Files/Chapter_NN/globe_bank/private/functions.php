<?php

    function url_for($script_path) {
        /* This function uses WWW_ROOT defined in "initialize.php"
           to set the path to any file within the "/public" folder*/

        // add the leading '/' if not present
        if($script_path[0] != '/') {
            $script_path = "/" . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    function u($string = "") {
        // urlencode turns special characters into
        // encoded equivalents - turns space into '+'
        // Used for path after '?' in url
        return urlencode($string);

    }

    function raw_u($string = "") {
        // urlencode turns special characters into
        // encoded equivalents - turns space into "%20"
        // Used for path before '?' in url
        return rawurlencode($string);

    }

    function h($string = "") {
        // htmlspecialchars() prevents cross-site scripting
        // will be using htmlspecialchars() alot
        return htmlspecialchars($string);
    }

    function error_404() {
        // Changes the header to ouput 404 error
        return header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        exit();
    }

    function error_500() {
        // Changes the header to ouput 500 error
        return header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        exit();
    }

    function redirect_to($location) {
        // Redirects user from the current page
        // to the passed-in page
        header("Location: " . $location);
        exit();
    }

    function is_post_request() {
      // Checks to see if the form request is a POST
      return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    function is_get_request() {
      // Checks to see if the form request is a GET
      return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    function display_errors($errors = array()) {
        // Displays each error in the passed-in array
        // as a list item in the list
        $output = "";
        if(!empty($errors)) {
            $output .= "<div class=\"errors\">";
            $output .= "Please fix the following errors:";
            $output .= "<ul>";
            foreach($errors as $error) {
                $output .= "<li>" . h($error) . "</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
        }
        return $output;
    }

    function display_error_pages($page_names = array()) {
        // Displays each error in the passed-in array
        // as a list item in the list
        $output = "";
        if(!empty($page_names)) {
            $output .= "<div class=\"errors\">";
            $output .= "The following pages still use this subject:";
            $output .= "<ul>";
            foreach($page_names as $page) {
                $output .= "<li>" . h($page) . "</li>";
            }
            $output .= "</ul>";
            $output .= "Please change the subject of these pages before deleting!";
            $output .= "</div>";
        }
        return $output;
    }


?>
