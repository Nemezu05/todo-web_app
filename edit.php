<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: app.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch task to edit
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: app.php");
    exit;
}

$task = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $priority = $_POST['priority'] ?? 'low';

    $update = $conn->prepare("UPDATE tasks SET title = ?, priority = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("ssii", $title, $priority, $id, $user_id);
    $update->execute();

    header("Location: app.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], select, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Edit Task</h2>
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
        <select name="priority">
            <option value="low" <?= $task['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
            <option value="medium" <?= $task['priority'] === 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="high" <?= $task['priority'] === 'high' ? 'selected' : '' ?>>High</option>
        </select>
        <button type="submit">Update Task</button>
    </form>
</body>
</html>
