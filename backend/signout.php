<?php
    // Start the session
    session_start();

    // Destroy all session variables
    session_unset();  // Remove all session variables

    // Destroy the session
    session_destroy();  // End the session

    // Redirect to the login page after logging out
    header("Location: ../");  // Or wherever you want to redirect
    exit();
?>

