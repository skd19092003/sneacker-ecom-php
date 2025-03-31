// Fetch the session data from the PHP file
fetch("session.php")
.then(response => response.json())
.then(data => {
    if (data.username) {
        console.log("Username from session:", data.username);
        alert("Welcome, " + data.username);
    } else {
        console.log("No session found, redirecting to login...");
        // Redirect to the login page if no session is found
        window.location.href = "auth.php";
    }
})
.catch(error => console.error("Error fetching session:", error));