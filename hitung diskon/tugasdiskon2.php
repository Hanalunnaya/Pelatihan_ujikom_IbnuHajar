<?php
// Function untuk menghitung diskon
function hitungDiskon($totalBelanja)
{
    if ($totalBelanja >= 100000) {
        return $totalBelanja * 0.10; // Diskon 10%
    } elseif ($totalBelanja >= 50000) {
        return $totalBelanja * 0.05; // Diskon 5%
    } else {
        return 0; // Tidak dapat diskon
    }
}

// Procedure untuk menampilkan hasil akhir
function tampilkanTotal($totalBelanja)
{
    $diskon = hitungDiskon($totalBelanja);
    $totalBayar = $totalBelanja - $diskon;

    echo "Total Belanja: Rp" . number_format($totalBelanja, 0, ',', '.') . "<br>";
    echo "Diskon: Rp" . number_format($diskon, 0, ',', '.') . "<br>";
    echo "Total Bayar: Rp" . number_format($totalBayar, 0, ',', '.') . "<br>";
}

// Input dari pengguna
echo "<form method='POST'>";
echo "Masukkan Total Belanja: <input type='number' name='totalBelanja' required> ";
echo "<button type='submit'>Hitung</button>";
echo "</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalBelanja = $_POST['totalBelanja'];
    tampilkanTotal($totalBelanja);
}
