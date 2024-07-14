<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Custom error handler function
function customError($errno, $errstr, $errfile, $errline) {
    // Log the error details
    error_log("Error [$errno]: $errstr in $errfile on line $errline". PHP_EOL, 3, "error_log.txt");

    // Redirect to a custom error page
    if ($errno == E_USER_ERROR || $errno == E_RECOVERABLE_ERROR) {
        header("Location: 500.php");
        exit();
    }
}

// Set the custom error handler
set_error_handler("customError");

// Exception handler
function customExceptionHandler($exception) {
    // Log the exception details
    error_log("Uncaught Exception: " . $exception->getMessage() . PHP_EOL, 3, "error_log.txt");

    // Redirect to a custom error page
    header("Location: 500.php");
    exit();
}

// Set the custom exception handler
set_exception_handler("customExceptionHandler");

// Custom 404 handling
if (!file_exists($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.0 404 Not Found");
    include('404.php');
    exit();
}


?>
