<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] === 'POST'){
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "INSERT INTO `profile-details`( username, email, phone, password) VALUES( '$username', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Success: show alert and redirect back to form
        echo "<script>
            alert('Form submitted successfully!');
            window.location.href = 'signin.html';
        </script>";
        exit();
    } else {
        // Failure: show error and stay on the page
        echo "<script>
            alert('Error submitting form: " . $conn->error . "');
            window.history.back();
        </script>";
    }

    $conn->close();
}
?>