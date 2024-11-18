<?php
session_start();
include '../core/functions.php';
include '../core/validations.php';
$errors = [];

if (checkRequestMethod("POST")) {
    // Sanitize the input data
    foreach ($_POST as $key => $value) {
        $$key = sanitizeInput($value);
    }

    // Email validation
    if (!requiredVal($email)) {
        $errors[] = "Email is required";
    } elseif (!emailVal($email)) {
        $errors[] = "Type a valid email";
    }

    // Password validation
    if (!requiredVal($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Open the CSV file for reading
        $usersFile = "../data/users.csv";
        if (($handle = fopen($usersFile, "r")) !== FALSE) {
            $authenticated = false;

            // Loop through the CSV file to find matching credentials
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $storedEmail = $data[1];
                $storedPassword = $data[2]; // Hashed password

                // Check if the entered email and hashed password match
                if ($storedEmail == $email && $storedPassword == sha1($password)) {
                    // Set session for authenticated user
                    $_SESSION['auth'] = [
                        'name' => $data[0], // Assuming first column is the name
                        'email' => $storedEmail
                    ];
                    $authenticated = true;
                    break;
                }
            }

            fclose($handle);

            if ($authenticated) {
                // Redirect to the home page or wherever you want after successful login
                redirect("../index.php");
            } else {
                $errors[] = "Invalid email or password.";
                $_SESSION['errors'] = $errors;
                redirect("../login.php");
            }
        } else {
            $errors[] = "Unable to open the users file.";
            $_SESSION['errors'] = $errors;
            redirect("../login.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect("../login.php");
    }
} else {
    echo "Unsupported request method.";
}
