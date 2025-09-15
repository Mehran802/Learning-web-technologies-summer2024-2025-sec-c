<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["username"]) || $_SESSION["type"] != "admin") {
    header("Location: login.html");
    exit();
}

$sql = "SELECT username, type FROM users";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
</head>
<body>
    <h2>Registered Users</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Username</th>
            <th>User Type</th>
        </tr>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No users found.</td></tr>";
        }
        ?>
    </table>
    <p><a href="admin_home.php">Back</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
<?php
mysqli_close($conn);
?>
