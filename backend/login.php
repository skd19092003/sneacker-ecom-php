<?php
include './db.php';
include 'hashfunction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['email'];
    $password = trim($_POST['password']);;

    
    // Retrieve the stored hashed password from the database
    $sql = "SELECT password FROM users WHERE email = '$userEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the stored hash
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];
        // echo $stored_hashed_password ." : " . $password;

        // Verify the entered password against the stored hash
        //  password_hash($password, PASSWORD_DEFAULT);
        // $hashed_password =custom_hash($password);
        // $hashed_password =consistent_hash($password);
        $hashed_password =$password;


        // echo " ####". $hashed_password." :-> ".$stored_hashed_password . "<br>";
     
        // if (password_verify($password, $stored_hashed_password)) {
        if($hashed_password===$stored_hashed_password){
            echo "Login successful! Welcome, " . htmlspecialchars($userEmail) . "!";
            // Start a session and store user data
            session_start();
            // Set session timeout in seconds (e.g., 10 minutes)
            $timeout_duration = 600;
            // Set session timeout to 10 minutes (600 seconds)
                ini_set('session.gc_maxlifetime', $timeout_duration);      // Session data is kept for 10 minutes
                ini_set('session.cookie_lifetime', $timeout_duration);      // Cookie expires after 10 minutes

            // Check if the "last activity" timestamp exists
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                // If the session has expired, destroy it
                session_unset();
                session_destroy();
                echo "Session expired. Please log in again.";
            } else {
                // Update the last activity time
                $_SESSION['LAST_ACTIVITY'] = time();
                echo "Session is active.";
            }

            $_SESSION['auth'] = true;
            $_SESSION['username'] = $userEmail;
            //render login
            if (isset($_SESSION['username'])) {
                echo json_encode(array("username" => $_SESSION['username']));
            } else {
                echo json_encode(array("username" => null));
            }

            header("Location: ../", true, 301);  // 301 Moved Permanently
            exit();
        } else {
            echo '<script>window.alert("email or password is incorrect")</script>';
            $conn->close();
            // header("Location: ../index.html", true, 301);  // 301 Moved Permanently
            // exit();
        }
    } else {
        echo '<script>window.alert("email is incorrect")</script>';
        $conn->close();
        // header("Location: ../index.html", true, 301);  // 301 Moved Permanently
        // exit();
    }

    
    // Close the connection

    
}
?>