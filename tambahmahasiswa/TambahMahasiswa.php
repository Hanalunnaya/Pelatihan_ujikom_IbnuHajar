<?php
include "koneksi.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["tambah"])) {
        $nim = htmlspecialchars($_POST["nim"]);
        $nama = htmlspecialchars($_POST["nama"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $jurusan = htmlspecialchars($_POST["jurusan"]);

        if (!empty($nama) && !empty($gender) && !empty($jurusan)) {
            $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, gender, jurusan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nim, $nama, $gender, $jurusan);
            if ($stmt->execute()) {
                $message = "Data berhasil ditambahkan!";
            } else {
                $message = "Gagal menambahkan data.";
            }
            $stmt->close();
        }
    } elseif (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $nim = htmlspecialchars($_POST["nim"]);
        $nama = htmlspecialchars($_POST["nama"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $jurusan = htmlspecialchars($_POST["jurusan"]);

        if (!empty($id) && !empty($nim) && !empty($nama) && !empty($gender) && !empty($jurusan)) {
            $stmt = $conn->prepare("UPDATE mahasiswa SET nim=?, nama=?, gender=?, jurusan=? WHERE id=?");
            $stmt->bind_param("ssss", $nim, $nama, $gender, $jurusan, $id);
            if ($stmt->execute()) {
                $message = "Data berhasil diperbarui!";
            } else {
                $message = "Gagal memperbarui data.";
            }
            $stmt->close();
        }
    } elseif (isset($_POST["hapus"])) {
        $id = $_POST["id"];
        if (!empty($id)) {
            $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Data berhasil dihapus!";
            } else {
                $message = "Gagal menghapus data.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Form Mahasiswa</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?= $message; ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="nim" class="form-control" placeholder="NIM" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Mahasiswa" required>
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select" required>
                    <option value="">Pilih Gender</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required>
            </div>
            <div class="col-md-3">
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </form>

    <!-- Tabel Mahasiswa -->
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM mahasiswa");
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nim']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['gender']); ?></td>
                        <td><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editData('<?= $row['id']; ?>', '<?= $row['nim'] . " - " . $row['nama']; ?>', '<?= $row['gender']; ?>', '<?= $row['jurusan']; ?>')">Edit</button>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <input type="text" name="nim" id="editNIM" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <select name="gender" id="editGender" class="form-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required>
                    </div>
                    <button type="submit" name="edit" class="btn btn-success">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editData(id, nim, nama, gender, jurusan) {
    document.getElementById('editId').value = id;
    document.getElementById('editNIM').value = nim;
    document.getElementById('editNama').value = nama;
    document.getElementById('editGender').value = gender;
    document.getElementById('editJurusan').value = jurusan;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
</body>
</html>
