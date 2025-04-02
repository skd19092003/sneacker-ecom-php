<?php
include 'db.php';
include 'hashfunction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = trim($_POST['password']);;
    $password2 = trim($_POST['confirmpassword']);;
    $phoneNumber= $_POST['phoneNumber'];
    $gender=$_POST['gender'];
    if($password1!==$password2){
        echo '<script>window.alert("Both password Mis-matched")</script>' ;
        $conn->close();
        header("Location: ../", true, 301);  // 301 Moved Permanently
        exit();
    }
    
    $sql = "SELECT password FROM users WHERE email = '$email' OR username='$username' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<script>window.alert("email already exist")</script>' ;  
        $conn->close();
        header("Location: ../", true, 301);  // 301 Moved Permanently
        exit();
    }
    else{
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $hashed_password =custom_hash($password);
        // $hashed_password =consistent_hash($password);
        $hashed_password =$password1;

        $sql = "INSERT INTO users (username,email,password,phone, gender) VALUES ('$username', '$email', '$hashed_password','$phoneNumber','$gender')";
        // Execute the query
        echo " ".$conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            // echo "New record added successfully!";
            // Start the session
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
            if (isset($_SESSION['username'])) {
                echo json_encode(array("username" => $_SESSION['username']));
            } else {
                echo json_encode(array("username" => null));
            }
            $conn->close();
            header("Location: ../", true, 301);  // 301 Moved Permanently
            exit();
        } else {
            // echo "Error: " . $sql . "<br>" . $conn->error;
            echo '<script>window.alert("error in signing")</script>' ;
            $conn->close();  
            header("Location: ../", true, 301);  // 301 Moved Permanently
            exit();
        }
    }
    
}
?>