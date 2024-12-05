<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}

if (isset($_POST['export'])) {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="laporan_transaksi.csv"');
  $output = fopen('php://output', 'w');
  fputcsv($output, ['ID Transaksi', 'ID Buku', 'ID Anggota', 'Tanggal Pinjam', 'Tanggal Kembali']);
  $result = $conn->query("SELECT * FROM transaksi");
  while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
  }
  fclose($output);
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Laporan Transaksi</title>

  <head>
    <link rel="stylesheet" href="style.css">
  </head>

</head>

<body>
  <h2>Laporan Transaksi</h2>
  <form method="POST">
    <button type="submit" name="export">Export CSV</button>
  </form>
  <table border="1">
    <thead>
      <tr>
        <th>ID Transaksi</th>
        <th>ID Buku</th>
        <th>ID Anggota</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM transaksi");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['id_buku']}</td>
                        <td>{$row['id_anggota']}</td>
                        <td>{$row['tanggal_pinjam']}</td>
                        <td>{$row['tanggal_kembali']}</td>
                    </tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>