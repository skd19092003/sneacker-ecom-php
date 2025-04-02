
<?php

    session_start();

    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION['username']);
    echo '<script>console.log(isLoggedIn)</script>';
    if ($isLoggedIn) {
        // If logged in, show the home page
        include 'home.php';
    } else {
        // If not logged in, show the login/signup form
        include 'form.html';
    }

?>

