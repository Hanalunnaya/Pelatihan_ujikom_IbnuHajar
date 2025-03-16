<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-3">Tambah Barang</h2>

    <?php
    include "koneksi.php"; // Menggunakan koneksi dari koneksi.php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $no = $_POST['no'];
        $nama = $_POST['nama_merek'];
        $warna = $_POST['warna'];
        $jumlah = $_POST['jumlah'];

        $sql = "INSERT INTO printer (no, nama_merek, warna, jumlah) VALUES ('$no', '$nama_merek', '$warna', '$jumlah')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
    ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">No</label>
            <input type="text" name="no" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_merek" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Warna</label>
            <input type="text" name="warna" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="reset" class="btn btn-warning">Refresh</button>
        <a href="index.php" class="btn btn-danger">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
