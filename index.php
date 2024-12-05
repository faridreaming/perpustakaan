<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === 'admin' && $password === '123') {
    $_SESSION['login'] = true;
    header('Location: dashboard.php');
    exit();
  } else {
    $error = 'Username atau password salah!';
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Login Perpustakaan</title>

  <head>
    <link rel="stylesheet" href="style.css">
  </head>

</head>

<body>
  <h2>Login Admin</h2>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
  </form>
</body>

</html>