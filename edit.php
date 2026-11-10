<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location: login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php';
include 'kripto.php';

$id_barang = $_GET['id_barang'];
$query = mysqli_query($koneksi, "SELECT * FROM inventaris_barang WHERE id_barang='$id_barang'");
$d = mysqli_fetch_array($query);

$catatan_asli = decryptCaesar($d['catatan_suplier']);

if(isset($_POST['update'])){
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $catatan_baru = $_POST['catatan_suplier'];

    $catatan_encrypt = encryptCaesar($catatan_baru);

    $update = mysqli_query($koneksi, "UPDATE inventaris_barang SET nama_barang='$nama_barang', stok='$stok', catatan_suplier='$catatan_encrypt' WHERE id_barang='$id_barang'");

    if($update){
        header("location: index.php");
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Sistem Inventaris Gudang</title>
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
            border-radius: 50px;
            font-family: inherit;
            font-size: 15px;
            color: #ffffff;
            outline: none;
            transition: 0.3s;
        }

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
            background-color: #ffb300;
            border: none;
            color: #0f172a;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #ffca28;
            transform: scale(1.02);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #90caf9;
            font-size: 15px;
        }

        .back-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Edit Data Barang</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="<?php echo $d['nama_barang']; ?>" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" value="<?php echo $d['stok']; ?>" required>
        </div>
        <div class="form-group">
            <label>Catatan Suplier</label>
            <textarea name="catatan_suplier" rows="3" required><?php echo $catatan_asli; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn-primary">Update Data</button>
    </form>
    <a href="index.php" class="back-link">&larr; Kembali ke Dashboard</a>
</div>

</body>
</html>