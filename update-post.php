<?php

session_start();

require_once "config/db.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: login.html");
    exit();

}

// Check POST request
if ($_SERVER["REQUEST_METHOD"] != "POST") {

    echo "Invalid request.";
    exit();

}

$blog_id = intval($_POST["id"]);
$title = trim($_POST["title"]);
$content = trim($_POST["content"]);

$user_id = $_SESSION["user_id"];

// Update only if this blog belongs to the logged-in user
$sql = "UPDATE blogpost
        SET title = ?, content = ?, updated_at = NOW()
        WHERE id = ? AND user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("SQL Prepare Error: " . $conn->error);

}

$stmt->bind_param(
    "ssii",
    $title,
    $content,
    $blog_id,
    $user_id
);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        header("Location: post.php?id=" . $blog_id);
        exit();

    } else {

        echo "No changes made or you are not authorized to update this blog.";

    }

} else {

    echo "Update failed: " . $stmt->error;

}

$stmt->close();

$conn->close();

?>