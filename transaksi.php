<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}

// Handle Tambah Transaksi
if (isset($_POST['add'])) {
  $id_buku = $_POST['id_buku'];
  $id_anggota = $_POST['id_anggota'];
  $tanggal_pinjam = $_POST['tanggal_pinjam'];
  $tanggal_kembali = $_POST['tanggal_kembali'];

  // Tambahkan transaksi baru
  $conn->query("INSERT INTO transaksi (id_buku, id_anggota, tanggal_pinjam, tanggal_kembali) 
                  VALUES ('$id_buku', '$id_anggota', '$tanggal_pinjam', '$tanggal_kembali')");

  // Ubah status buku menjadi 'dipinjam'
  $conn->query("UPDATE buku SET status='dipinjam' WHERE id=$id_buku");

  header('Location: transaksi.php');
  exit();
}

// Ambil daftar transaksi
$transaksi_result = $conn->query("SELECT transaksi.id, buku.judul AS buku, anggota.nama AS anggota, 
    transaksi.tanggal_pinjam, transaksi.tanggal_kembali 
    FROM transaksi 
    JOIN buku ON transaksi.id_buku = buku.id 
    JOIN anggota ON transaksi.id_anggota = anggota.id");

// Ambil daftar buku dan anggota untuk dropdown
$buku_result = $conn->query("SELECT * FROM buku WHERE status='tersedia'");
$anggota_result = $conn->query("SELECT * FROM anggota");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Manajemen Transaksi</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Manajemen Transaksi</h1>
    <ul>
      <li><a href="dashboard.php" class="btn-back">Kembali</a></li>
      <li><a href="laporan.php">Laporan Transaksi</a></li>
    </ul>

    <h2>Daftar Transaksi</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Buku</th>
          <th>Anggota</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $transaksi_result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['buku'] ?></td>
            <td><?= $row['anggota'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <h2>Tambah Transaksi</h2>
    <form method="POST">
      <label for="id_buku">Pilih Buku</label>
      <select name="id_buku" id="id_buku" required>
        <option value="">-- Pilih Buku --</option>
        <?php while ($buku = $buku_result->fetch_assoc()): ?>
          <option value="<?= $buku['id'] ?>"><?= $buku['judul'] ?></option>
        <?php endwhile; ?>
      </select>

      <label for="id_anggota">Pilih Anggota</label>
      <select name="id_anggota" id="id_anggota" required>
        <option value="">-- Pilih Anggota --</option>
        <?php while ($anggota = $anggota_result->fetch_assoc()): ?>
          <option value="<?= $anggota['id'] ?>"><?= $anggota['nama'] ?></option>
        <?php endwhile; ?>
      </select>

      <label for="tanggal_pinjam">Tanggal Pinjam</label>
      <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required>

      <label for="tanggal_kembali">Tanggal Kembali</label>
      <input type="date" name="tanggal_kembali" id="tanggal_kembali" required>

      <button type="submit" name="add">Tambah Transaksi</button>
    </form>
  </div>
</body>

</html>