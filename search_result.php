<?php
include 'koneksi.php';

$keyword = $_GET['keyword'];
$sql = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['judul']} - {$row['pengarang']} ({$row['kategori']})</p>";
  }
} else {
  echo '<p>Tidak ada buku ditemukan.</p>';
}
