<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = trim($_POST["userid"]);
    $password = trim($_POST["password"]);

    $query = "SELECT password, type FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashed_password, $type);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION["username"] = $username;
        $_SESSION["type"] = $type;

        mysqli_close($conn);

        if ($type == "admin") {
            header("Location: admin_home.php");
        } else {
            header("Location: user_home.php");
        }
        exit();
    } else {
        echo "Invalid User ID or password.<br>";
        echo "<a href='login.html'>Try again</a>";
    }
} else {
    echo "Invalid request.<br>";
    echo "<a href='login.html'>Login</a>";
}
?>
