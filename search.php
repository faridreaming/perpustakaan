<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Pencarian Buku</title>

  <head>
    <link rel="stylesheet" href="style.css">
  </head>

  <script>
    function searchBooks() {
      const keyword = document.getElementById('keyword').value;
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'search_result.php?keyword=' + keyword, true);
      xhr.onload = function() {
        document.getElementById('result').innerHTML = this.responseText;
      };
      xhr.send();
    }
  </script>
</head>

<body>
  <h2>Pencarian Buku</h2>
  <input type="text" id="keyword" onkeyup="searchBooks()" placeholder="Cari buku...">
  <div id="result"></div>
</body>

</html>