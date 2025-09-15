<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $username = $_SESSION["username"];


    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashed_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($hashed_password && password_verify($old_password, $hashed_password)) {
        
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        
        $update_sql = "UPDATE users SET password = ? WHERE username = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "ss", $new_hashed_password, $username);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Password changed successfully.";
        } else {
            $msg = "Error occurred. Try again.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $msg = "Old password is incorrect.";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form method="post" action="">
        Old Password:<br>
        <input type="password" name="old_password" required><br><br>

        New Password:<br>
        <input type="password" name="new_password" required><br><br>

        <input type="submit" value="Change Password">
    </form>
    <p><?php echo $msg; ?></p>
    <p><a href="<?php echo ($_SESSION["type"] == "admin") ? 'admin_home.php' : 'user_home.php'; ?>">Back</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
