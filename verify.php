<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['verification_code'])) {
    header("Location: login.php");
    exit();
}

$verification_code = $code_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["verification_code"]))) {
        $code_err = "Please enter the verification code.";
    } else {
        $verification_code = trim($_POST["verification_code"]);
    }

    if (empty($code_err)) {
        if ($verification_code == $_SESSION['verification_code']) {
            unset($_SESSION['verification_code']);
            $_SESSION['loggedin'] = true;

            if ($_SESSION['is_admin'] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $code_err = "The verification code is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Verify</h1>
        <?php if ($code_err): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($code_err, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form action="verify.php" method="post">
            <div class="form-group">
                <label for="verification_code">Verification Code:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='login.php'">Cancel</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
