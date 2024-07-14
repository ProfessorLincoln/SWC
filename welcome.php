<?php

session_start();
require 'error_page.php';
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        $password_update_message = "Password updated successfully!";
    } else {
        $password_update_error = "Error updating password: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Change Password</h2>
        <?php if (isset($password_update_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $password_update_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($password_update_error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $password_update_error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="welcome.php">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
        <br>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="index.php" class="btn btn-secondary">Home</a>
    </div>
</body>
</html>
