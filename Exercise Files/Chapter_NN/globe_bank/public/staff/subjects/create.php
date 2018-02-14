<?php


    // NOTE: This page is NOT used anymore since the page which utilized it,
    // new.php, now is implementing single-page form submission


    
    require_once("../../../private/initialize.php");

    // If statement below makes sure that the only way
    // to access this page is by submitting the form -
    // through POST request instead of GET request
    if (is_post_request()) {
        // Handle form values sent by new.php

        $subject = [];
        $subject["menu_name"] = $_POST['menu_name'] ?? '';
        $subject["position"] = $_POST['position'] ?? '';
        $subject["visible"] = $_POST['visible'] ?? '';

        $result = insert_subject($subject);

        if ($result === true) {
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for("/staff/subjects/show.php?id=" . $new_id));
        } else {
            $errors = $result;
        }

    } else {
        redirect_to(url_for("/staff/subjects/new.php"));
    }

?>
