<?php
session_start();
include ('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$conn->query("UPDATE tasks SET completed = NOT completed WHERE id = $id");

header("Location: app.php");
