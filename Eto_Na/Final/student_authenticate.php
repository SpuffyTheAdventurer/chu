<?php
session_start();
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['student_logged_in'] = true;
        header("Location: products2.php");
        exit;
    } else {
        // Redirect with an error parameter
        header("Location: student_login.php?error=invalid_credentials");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style for the popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid black;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
    </style>
    <script>
        window.onload = function() {
            // Check if there is an error parameter in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');

            // If the error parameter is present and it indicates invalid credentials, show the popup
            if (error === 'invalid_credentials') {
                document.getElementById('popup').style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <!-- Popup for displaying the error message -->
    <div id="popup" class="popup">
        <p>Invalid username or password.</p>
    </div>

    <!-- Your HTML content for the login page -->
</body>
</html>