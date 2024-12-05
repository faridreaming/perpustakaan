<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  exit();
}

// Handle Tambah Buku
if (isset($_POST['add'])) {
  $judul = $_POST['judul'];
  $pengarang = $_POST['pengarang'];
  $kategori = $_POST['kategori'];
  $status = $_POST['status'];

  $conn->query("INSERT INTO buku (judul, pengarang, kategori, status) VALUES ('$judul', '$pengarang', '$kategori', '$status')");
  header('Location: dashboard.php');
  exit();
}

// Handle Hapus Buku
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM buku WHERE id = $id");
  header('Location: dashboard.php');
  exit();
}

// Handle Edit Buku
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $judul = $_POST['judul'];
  $pengarang = $_POST['pengarang'];
  $kategori = $_POST['kategori'];
  $status = $_POST['status'];

  $conn->query("UPDATE buku SET judul='$judul', pengarang='$pengarang', kategori='$kategori', status='$status' WHERE id=$id");
  header('Location: dashboard.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="style.css">
  <script>
    // Fungsi pencarian buku
    function searchBooks() {
      let keyword = document.getElementById('keyword').value.toLowerCase();
      let rows = document.querySelectorAll('table tbody tr');
      rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
      });
    }
  </script>
</head>

<body>
  <div class="container">
    <h1>Dashboard Admin</h1>
    <ul>
      <li><a href="transaksi.php">Manajemen Transaksi</a></li>
      <li><a href="anggota.php">Manajemen Anggota</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>


    <h2>Daftar Buku</h2>

    <!-- Pencarian -->
    <input type="text" id="keyword" placeholder="Cari buku..." onkeyup="searchBooks()">

    <!-- Tabel Buku -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul</th>
          <th>Pengarang</th>
          <th>Kategori</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM buku");
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['judul']}</td>
                        <td>{$row['pengarang']}</td>
                        <td>{$row['kategori']}</td>
                        <td>{$row['status']}</td>
                        <td>
                          <div class='btn-aksi'>
                            <a class='edit' href='dashboard.php?edit={$row['id']}'>Edit</a>
                            <a class='hapus' href='dashboard.php?delete={$row['id']}' onclick='return confirm(\"Hapus buku ini?\")'>Hapus</a>
                          </div>
                        </td>
                    </tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Form Tambah/Edit Buku -->
    <h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah'; ?> Buku</h2>
    <form method="POST">
      <?php
      if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $edit_result = $conn->query("SELECT * FROM buku WHERE id=$id");
        $edit_data = $edit_result->fetch_assoc();
        echo "<input type='hidden' name='id' value='{$edit_data['id']}'>";
      }
      ?>
      <label>Judul</label>
      <input type="text" name="judul" value="<?php echo isset($edit_data) ? $edit_data['judul'] : ''; ?>" required>
      <label>Pengarang</label>
      <input type="text" name="pengarang" value="<?php echo isset($edit_data) ? $edit_data['pengarang'] : ''; ?>" required>
      <label>Kategori</label>
      <input type="text" name="kategori" value="<?php echo isset($edit_data) ? $edit_data['kategori'] : ''; ?>" required>
      <label>Status</label>
      <select name="status" required>
        <option value="tersedia" <?php echo isset($edit_data) && $edit_data['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
        <option value="dipinjam" <?php echo isset($edit_data) && $edit_data['status'] == 'dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
      </select>
      <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add'; ?>">
        <?php echo isset($_GET['edit']) ? 'Simpan Perubahan' : 'Tambah Buku'; ?>
      </button>
    </form>
    <a href="dashboard.php" class="btn-back">Kembali</a>
  </div>
</body>

</html>