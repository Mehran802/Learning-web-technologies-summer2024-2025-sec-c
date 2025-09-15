<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["type"] != "admin") {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
  
  <p>Welcome: <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
  <ul>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="view_users.php">View Users</a></li>
    <li><a href="change_password.php">Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
