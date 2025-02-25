<?php
// Connect to database
$mysqli = new mysqli("localhost", "username", "password", "login_system");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if form is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        // Check password
        if (password_verify($password, $hashedPassword)) {
            // Start session
            session_start();
            $_SESSION['username'] = $username;
            
            // Set secure cookie
            setcookie('login', 'true', time() + 3600, '/', '', true, true);
            
            // Redirect to protected page
            header('Location: protected.php');
            exit;
        } else {
            echo 'Invalid username or password.';
        }
    } else {
        echo 'Invalid username or password.';
    }
}
?>
