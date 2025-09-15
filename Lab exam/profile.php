<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>PROFILE</title>
</head>
<body>
  <h2>PROFILE PAGE</h2>
  <p>Username: <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
  <p>User Type: <?php echo htmlspecialchars($_SESSION["type"]); ?></p>
  <p><a href="<?php echo ($_SESSION["type"] == "admin" ? "admin_home.php" : "user_home.php"); ?>">Back</a></p>
  <p><a href="logout.php">Logout</a></p>
</body>
</html>
