<?php
include('../config/con.php');

// Individual post deletion
if (isset($_POST['delete'])) {
    $teamid = $_POST['delete'];

    $sql = "DELETE FROM team WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $teamid);

    if ($stmt->execute()) {
        echo "Deleted successfully.";
    } else {
        echo "Error deleting post: " . $conn->error;
    }
    header("Location: teams.php"); // Redirect back to post list
    exit();
}

// Bulk post deletion
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['ids'])) {
        $ids = $_POST['ids'];
        $placeholders = implode(',', array_fill(0, count($ids), '?')); // Prepare placeholders for SQL

        $sql = "DELETE FROM team WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Bind multiple parameters
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

        if ($stmt->execute()) {
            echo "Selected posts deleted successfully.";
        } else {
            echo "Error deleting posts: " . $conn->error;
        }
        header("Location: teams.php"); // Redirect back to post list
        exit();
    }
}
