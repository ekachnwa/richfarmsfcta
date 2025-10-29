<?php
include('../config/con.php');

// Individual post deletion
if (isset($_POST['delete'])) {
    $postid = $_POST['delete'];

    $sql = "DELETE FROM post WHERE postid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $postid);

    if ($stmt->execute()) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . $conn->error;
    }
    header("Location: post.php"); // Redirect back to post list
    exit();
}

// Bulk post deletion
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['postids'])) {
        $postids = $_POST['postids'];
        $placeholders = implode(',', array_fill(0, count($postids), '?')); // Prepare placeholders for SQL

        $sql = "DELETE FROM post WHERE postid IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Bind multiple parameters
        $stmt->bind_param(str_repeat('i', count($postids)), ...$postids);

        if ($stmt->execute()) {
            echo "Selected posts deleted successfully.";
        } else {
            echo "Error deleting posts: " . $conn->error;
        }
        header("Location: post.php"); // Redirect back to post list
        exit();
    }
}
?>
