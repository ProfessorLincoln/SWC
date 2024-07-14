<?php
session_start();
require 'error_page.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prevent admin from deleting their own account
    if ($user_id != $_SESSION['user_id']) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: admin.php");
exit();
?>
