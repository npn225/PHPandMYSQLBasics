<?php

    // Pages Table Functions

    function validate_page($page) {

        $errors = [];

        // subject_id
        // Make sure we are working with an integer
        // since form values only return strings
        $subject_id_int = (int) $page['subject_id'];
        if ($subject_id_int <= 0) {
            $errors[] = "Subject ID must be greater than zero.";
        }
        if ($subject_id_int > 99999999999) {
            $errors[] = "Subject ID must be less than 99,999,999,999.";
        }


        // menu_name
        if (is_blank($page['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        } elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }
        //Check page menu_name for uniqueness
        if (!has_unique_page_menu_name($page)){
            $errors[] = "The Menu Name \"" . $page["menu_name"] .
            "\" is already in use by another page!  Please choose another Menu Name! ";
        };


        // position
        // Make sure we are working with an integer
        // since form values only return strings
        $postion_int = (int) $page['position'];
        if ($postion_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        if ($postion_int > 999) {
            $errors[] = "Position must be less than 999.";
        }


        // visible
        // Make sure we are working with a string
        $visible_str = (string) $page['visible'];
        if (!has_inclusion_of($visible_str, ["0","1"])) {
            $errors[] = "Visible must be true or false.";
        }


        // content
        if (is_blank($page['content'])) {
            $errors[] = "Content cannot be blank.";
        } elseif (!has_length($page['content'], ['min' => 2, 'max' => 65500])) {
            $errors[] = "Content must be between 2 and 65,500 characters.";
        }

        return $errors;
    }

    function find_all_pages() {
        // Finds and returns all the pages in the
        // page table of the globe_bank database

        // Since $db is a global variable and not defined inside this function,
        // must declare it "global" so that this function can use it
        global $db;

        // Creates the SQL query which will return the
        // pages table from the globe_bank database
        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY subject_id ASC, position ASC;";

        // Uses our database connection and the above sql query
        // to return the page table from the globe_bank database
        $result =  mysqli_query($db, $sql);

        // Checks the sql query used by result_set for errors or problems
        confirm_query_result_set($result, $sql);

        return $result;
    }

    function find_page_by_id($id) {
        // Uses the passed-in $id value to find
        // the appropriate page in the pages
        // table from the globe_bank database

        // Get access to database by declaring it global
        global $db;

        // For security purposes, always put single strings
        // around the variable-values in an sql-query string
        // as shown below
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id = '" . db_escape($db, $id) . "';";
        $result = mysqli_query($db, $sql); // Returns a result-set
        confirm_query_result_set($result, $db);

         // Get the row from the pages table in the
         // globe_bank database given by $result
        $page = mysqli_fetch_assoc($result);

        // Free up Memory space
        mysqli_free_result($result);

        return $page;  // returns an associatve array
    }

    function insert_page($page) {
        // Inserts a new record into the globe_bank database's
        // pages table

        // Need to make database connection global for use inside function
        global $db;

        // Validate the passed-in page
        // before inserting the page
        $errors = validate_page($page);
        if (!empty($errors)) {
            return $errors;
        }

        // For security reasons, always put signle quotes
        // around variable-values when dealing with sql
        $sql = "INSERT INTO pages ";
        $sql .= "(subject_id, menu_name, position, visible, content) VALUES (";
        $sql .= "'" . db_escape($db, $page["subject_id"]) . "', ";
        $sql .= "'" . db_escape($db, $page["menu_name"]) . "', ";
        $sql .= "'" . db_escape($db, $page["position"]) . "', ";
        $sql .= "'" . db_escape($db, $page["visible"]) . "', ";
        $sql .= "'" . db_escape($db, $page["content"]) . "'";
        $sql .= ");";

        // 'mysqli_query()' returns true/false for INSERT statement
        $result = mysqli_query($db, $sql);

        // If INSERT succeeded,
        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_page($page) {
        // Updates an existing record in the pages table
        // of the globe_bank database

        // Must make database global in order for
        // function to have access
        global $db;

        // Validate the passed-in page
        // before inserting the page
        $errors = validate_page($page);
        if (!empty($errors)) {
            return $errors;
        }

        // For security purposes, always add the signle-quotes
        // around variable-values for sql
        $sql = "UPDATE pages SET ";
        $sql .= "subject_id = '" . db_escape($db, $page["subject_id"]) . "', ";
        $sql .= "menu_name = '" . db_escape($db, $page["menu_name"]) . "', ";
        $sql .= "position = '" . db_escape($db, $page["position"]) . "', ";
        $sql .= "visible = '" . db_escape($db, $page["visible"]) . "', ";
        $sql .= "content = '" . db_escape($db, $page["content"]) . "' ";
        $sql .= "WHERE id = '" . db_escape($db, $page["id"]) . "' ";
        $sql .= "LIMIT 1;";

        // 'mysqli_query()' returns true/false for UPDATE queries
        $result = mysqli_query($db, $sql);

        // Returns the value true only if
        // the 'mysqli_query' succeeded
        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function delete_page($id) {
        // Deletes the appropriate record
        // in the pages table of the
        // globe_bank database

        // Make database connection variable global
        // in order for this function to have
        // access to it
        global $db;

        // Create sql query for deletion
        // of specified record
        $sql = "DELETE FROM pages ";
        $sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1;";

        // 'mysqli_query()' returns true/false for
        // a DELETE query
        $result = mysqli_query($db, $sql);

        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function has_unique_page_menu_name($page) {
        // Makes sure that every page menu_name is unique
        // and that a name cannot be reused

        // Makes sure id from $page is an int
        // Makes sure main_id has value for
        // the case of a new page being made
        // NOTE: No page in the globe_bank database has an
        // id of zero
        $main_id = (int) $page["id"] ?? 0;

        $menu_name = $page["menu_name"];
        $result = find_all_pages();

        // Loop through all the pages and check all their names
        while ($page1 = mysqli_fetch_assoc($result)) {
            $id = (int) $page1["id"];

            // If statement ONLY executes if the names are equal but
            // the id values are not
            if ($page1["menu_name"] === $menu_name && $id !== $main_id) {
                mysqli_free_result($result);
                return false;
            }
        }

        mysqli_free_result($result);
        return true;
    }



    // Subjects Table Functions

    function validate_subject($subject) {

        $errors = [];

        // menu_name
        if (is_blank($subject['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }

        // position
        // Make sure we are working with an integer
        // since form values only return strings
        $postion_int = (int) $subject['position'];
        if ($postion_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        if ($postion_int > 999) {
            $errors[] = "Position must be less than 999.";
        }

        // visible
        // Make sure we are working with a string
        $visible_str = (string) $subject['visible'];
        if (!has_inclusion_of($visible_str, ["0","1"])) {
            $errors[] = "Visible must be true or false.";
        }

        return $errors;
    }

    function find_all_subjects() {
        // Finds and returns all the subjects in
        // the subject table of the globe_bank database

        // Since $db is a global variable and not defined inside this function,
        // must declare it "global" so that this function can use it
        global $db;

        // Creates the SQL query which will return the sujects table
        // from the globe_bank database
        $sql = "SELECT * FROM subjects ";
        $sql .= "ORDER BY position ASC;";

        // Uses our database connection and sql query to get the
        // database information
        $result =  mysqli_query($db, $sql);

        // Checks the sql query used by result_set for errors or problems
        confirm_query_result_set($result, $sql);

        return $result;
    }

    function find_subject_by_id($id) {
        // Uses the passed-in $id value to find
        // the appropriate subject in the subjects
        // table from the globe_bank database

        // Get access to database by declaring it global
        global $db;

        // For security purposes, always put single strings
        // around the variable-values in an sql-query string
        // as shown below
        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE id = '" . db_escape($db, $id) . "';";
        $result = mysqli_query($db, $sql); // Returns a result-set
        confirm_query_result_set($result, $sql);

        // Get the row from the subjects table in
        // the globe_bank database given by $result
        $subject = mysqli_fetch_assoc($result);

        // Free up memory space
        mysqli_free_result($result);

        return $subject; // returns an associatve array
    }

    function insert_subject($subject) {
        // Inserts a new record into the globe_bank database's
        // subjects table

        // Make database connection global for use inside function
        global $db;

        // Validate the passed-in subject
        // before inserting the subject
        $errors = validate_subject($subject);
        if (!empty($errors)) {
            return $errors;
        }

        // For security reasons, always put signle quotes
        // around variable-values when dealing with sql
        $sql = "INSERT INTO subjects ";
        $sql .= "(menu_name, position, visible) VALUES (";
        $sql .= "'" . db_escape($db, $subject["menu_name"]) . "', ";
        $sql .= "'" . db_escape($db, $subject["position"]) . "', ";
        $sql .= "'" . db_escape($db, $subject["visible"]) . "'";
        $sql .= ");";

        //
        $result = mysqli_query($db, $sql);

        // If INSERT succeeded
        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_subject($subject) {
        // Updates an existing record in the pages table
        // of the globe_bank database

        // Must make database global in order for
        // function to have access
        global $db;

        // Validate the passed-in subject
        // before updating the subject
        $errors = validate_subject($subject);
        if (!empty($errors)) {
            return $errors;
        }

        // For security purposes, always add the signle-quotes
        // around variable-values for sql
        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name = '" . db_escape($db, $subject["menu_name"]) . "', ";
        $sql .= "position = '" . db_escape($db, $subject["position"]) . "', ";
        $sql .= "visible = '" . db_escape($db, $subject["visible"]) . "' ";
        $sql .= "WHERE id= '" . db_escape($db, $subject["id"]) . "' ";
        $sql .= "LIMIT 1;";

        // 'mysqli_query()' returns true/false for UPDATE queries
        $result = mysqli_query($db, $sql);

        // Returns the value true only if
        // the 'mysqli_query' succeeded
        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_subject($id) {
        // Deletes the appropriate record
        // in the subjects table of the
        // globe_bank database

        // Make database connection variable global
        // in order for this function to have
        // access to it
        global $db;

        // Create sql query for deletion
        // of specified record
        $sql = "DELETE FROM subjects ";
        $sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1;";

        // 'mysqli_query()' returns true/false for
        // a DELETE query
        $result = mysqli_query($db, $sql);

        if ($result) {
            return true;
        } else {
            // When $result == FALSE
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function find_subject_name($id) {
        // Returns the name of the subject (a string
        // value) associated with the passed-in id

        $subject = find_subject_by_id($id);

        return $subject["menu_name"];
    }

    function has_unused_subject_id($subject) {
        // Returns an array of page menu_names for all the pages
        // still using the passed-in subject's id value

        $page_names = [];

        // Make sure $id value is an int since it's
        // possible it came from a post request
        $id = (int) $subject["id"];

        $result = find_all_pages();

        // Loop through all the pages and check all their subject_ids
        while ($page = mysqli_fetch_assoc($result)) {
            // Make sure $subject_id value is an int
            $subject_id = (int) $page["subject_id"];

            // Append menu_name of page still using the passed-in
            // subject's id into 'page_names' array
            if ($id === $subject_id) {
                $page_names[] = $page["menu_name"];
            }
        }

        mysqli_free_result($result);
        return $page_names;

    }

?>
