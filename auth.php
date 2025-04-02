
<?php
    session_start();
    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION['username']);
?>