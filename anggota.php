<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}

// Handle Tambah Anggota
if (isset($_POST['add'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $nomor_telepon = $_POST['nomor_telepon'];

  $conn->query("INSERT INTO anggota (nama, email, nomor_telepon) VALUES ('$nama', '$email', '$nomor_telepon')");
  header('Location: anggota.php');
  exit();
}

// Handle Hapus Anggota
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM anggota WHERE id = $id");
  header('Location: anggota.php');
  exit();
}

// Handle Edit Anggota
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $nomor_telepon = $_POST['nomor_telepon'];

  $conn->query("UPDATE anggota SET nama='$nama', email='$email', nomor_telepon='$nomor_telepon' WHERE id=$id");
  header('Location: anggota.php');
  exit();
}

// Ambil data anggota
$result = $conn->query("SELECT * FROM anggota");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Manajemen Anggota</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Manajemen Anggota</h1>
    <a href="dashboard.php" class="btn-back">Kembali</a>

    <h2>Daftar Anggota</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Nomor Telepon</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['nomor_telepon'] ?></td>
            <td>
              <div class="btn-aksi">
                <a class="edit" href="anggota.php?edit=<?= $row['id'] ?>">Edit</a>
                <a class="hapus" href="anggota.php?delete=<?= $row['id'] ?>" onclick="return confirm('Hapus anggota ini?')">Hapus</a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah'; ?> Anggota</h2>
    <form method="POST">
      <?php
      if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $edit_result = $conn->query("SELECT * FROM anggota WHERE id=$id");
        $edit_data = $edit_result->fetch_assoc();
        echo "<input type='hidden' name='id' value='{$edit_data['id']}'>";
      }
      ?>
      <label>Nama</label>
      <input type="text" name="nama" value="<?php echo isset($edit_data) ? $edit_data['nama'] : ''; ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?php echo isset($edit_data) ? $edit_data['email'] : ''; ?>" required>
      <label>Nomor Telepon</label>
      <input type="text" name="nomor_telepon" value="<?php echo isset($edit_data) ? $edit_data['nomor_telepon'] : ''; ?>" required>
      <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add'; ?>">
        <?php echo isset($_GET['edit']) ? 'Simpan Perubahan' : 'Tambah Anggota'; ?>
      </button>
    </form>
  </div>
</body>

</html>