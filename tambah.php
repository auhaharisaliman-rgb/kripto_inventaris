<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location: login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php';
include 'kripto.php';

// Jika tombol simpan ditekan
if(isset($_POST['simpan'])){
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $catatan_raw = $_POST['catatan_suplier'];

    // ENKRIPSI otomatis catatan suplier sebelum disimpan ke database
    $catatan_encrypt = encryptCaesar($catatan_raw);

    // Simpan ke database
    $query = mysqli_query($koneksi, "INSERT INTO inventaris_barang (nama_barang, stok, catatan_suplier) VALUES ('$nama_barang', '$stok', '$catatan_encrypt')");

    if($query){
        header("location: index.php");
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Inventaris Gudang</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f2027 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 20px rgba(41, 128, 185, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 450px;
            color: #ffffff;
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #e3f2fd;
            text-align: center;
            font-size: 26px;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #bbdefb;
            font-size: 15px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 20px;
            background-color: #0f172a;
            border: 2px solid #1e3c72;
            border-radius: 50px; /* Bentuk kapsul */
            box-sizing: border-box;
            font-family: inherit;
            font-size: 15px;
            color: #ffffff;
            outline: none;
            transition: 0.3s;
        }

        /* Khusus textarea sudutnya dibuat sedikit melengkung elegan agar tetap rapi */
        .form-group textarea {
            border-radius: 20px;
            resize: vertical;
        }

        .form-group input:focus, .form-group textarea:focus {
            background-color: #1e293b;
            border-color: #2196f3;
            box-shadow: 0 0 8px rgba(33, 150, 243, 0.6);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #2196f3;
            border: none;
            color: white;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #64b5f6;
            transform: scale(1.02);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #90caf9;
            font-size: 15px;
            transition: 0.3s;
        }

        .back-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Tambah Data Barang</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" required autocomplete="off" placeholder="Masukkan nama barang...">
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" required placeholder="Jumlah stok...">
        </div>
        <div class="form-group">
            <label>Catatan Suplier (Otomatis dienkripsi)</label>
            <textarea name="catatan_suplier" rows="3" required placeholder="Contoh: Suplier utama via PT Maju Jaya"></textarea>
        </div>
        <button type="submit" name="simpan" class="btn-primary">Simpan Data</button>
    </form>
    <a href="index.php" class="back-link">&larr; Kembali ke Dashboard</a>
</div>

</body>
</html>