<?php
session_start();
include ('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$priority = $_POST['priority'] ?? 'low'; // fallback to 'low' if priority isn't selected

// Ensure created_at and priority are saved too
$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, priority, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iss", $user_id, $title, $priority);
$stmt->execute();

header("Location: app.php");
exit;
?>
