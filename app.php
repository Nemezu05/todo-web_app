<?php
session_start();
include ('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Todo List</title>
  <link rel="stylesheet" href="style2.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 20px;
    }
    h2 {
      color: #007bff;
    }
    form {
      margin-bottom: 20px;
    }
    input[type="text"] {
      padding: 10px;
      width: 300px;
    }
    button {
      padding: 10px;
      background-color: rgb(0, 123, 255);
      color: white;
      cursor: pointer;
      border: none;
    }
    button:hover {
      transform: scale(1.1);
      transition: transform 0.2s ease-in-out;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    #logout {
      text-decoration: none;
      color: #007bff;
      border: 1px solid rgb(0, 123, 255);
      padding: 7px;
    }
    #logout:hover {
      color: black;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    li {
      background: #fff;
      padding: 10px;
      margin-bottom: 10px;
      border-left: 5px solid rgb(0, 123, 255);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .actions a {
      margin-left: 10px;
      text-decoration: none;
      color: #007bff;
    }
    .timestamp {
      font-size: 0.85em;
      color: gray;
    }
    .priority {
      font-size: 0.85em;
      padding: 2px 6px;
      border-radius: 4px;
      margin-left: 10px;
    }
    .priority.high { background: red; color: white; }
    .priority.medium { background: orange; color: white; }
    .priority.low { background: green; color: white; }
  </style>
</head>
<body>
  <h2>Welcome, <?= $_SESSION['email']; ?></h2>

  <form action="add.php" method="POST">
    <input type="text" name="title" placeholder="New Task..." required />
    <select name="priority">
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>
    <button type="submit">Add</button>
  </form>

  <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
      <li>
        <span>
          <?= $row['completed'] ? "<s>{$row['title']}</s>" : $row['title'] ?>
          <span class="priority <?= $row['priority'] ?>"><?= ucfirst($row['priority']) ?></span>
          <div class="timestamp">Added on: <?= date('M d, Y h:i A', strtotime($row['created_at'])) ?></div>
        </span>
        <span class="actions">
          <a href="update.php?id=<?= $row['id'] ?>">[✔]</a>
          <a href="edit.php?id=<?= $row['id'] ?>">[✏️]</a>
          <a href="delete.php?id=<?= $row['id'] ?>">[🗑]</a>
        </span>
      </li>
    <?php endwhile; ?>
  </ul>

  <a href="logout.php" id="logout">Logout</a>
</body>
</html>
