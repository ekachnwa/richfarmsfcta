<?php
    // Clear all session data
    session_start();
    $_SESSION = ['id'];
    $_SESSION = ['email'];

    // Destroy the session
    session_destroy();

    // Redirect to index
    header("Location: index.php");
    exit();
?>
