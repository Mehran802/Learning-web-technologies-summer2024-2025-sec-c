<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get inputs exactly as per HTML form
    $username = trim($_POST["id"]);        // ID field in form is 'id', mapped to username
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $name = trim($_POST["name"]);          // Name field (optional: you can store or ignore depending on DB)
    $type = strtolower(trim($_POST["type"]));

    // Simple validation for user type
    if ($type != "admin" && $type != "user") {
        echo "Type must be 'admin' or 'user'.<br>";
        echo "<a href='register.html'>Go back</a>";
        exit();
    }

    // Check password and confirm password match
    if ($password != $confirm_password) {
        echo "Passwords do not match.<br>";
        echo "<a href='register.html'>Go back</a>";
        exit();
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $check_query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "Username already exists. Please choose another.<br>";
        echo "<a href='register.html'>Go back</a>";
        mysqli_stmt_close($stmt);
        exit();
    }
    mysqli_stmt_close($stmt);

    
    $insert_query = "INSERT INTO users (username, password, type) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $type);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration successful.<br>";
        echo "<a href='login.html'>Go to login</a>";
    } else {
        echo "Error: Could not register.<br>";
        echo "<a href='register.html'>Try again</a>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.<br>";
    echo "<a href='register.html'>Go back</a>";
}
?>
