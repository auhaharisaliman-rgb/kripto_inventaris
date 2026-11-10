<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location: login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php';
include 'kripto.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Inventaris Gudang</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f2027 100%);
            min-height: 100vh;
            margin: 0;
            padding: 30px 20px;
            color: #ffffff;
        }

        .container {
            max-width: 1050px;
            margin: auto;
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 20px rgba(41, 128, 185, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 26px;
            color: #e3f2fd;
            letter-spacing: 0.5px;
        }

        .user-info {
            font-size: 16px;
            color: #bbdefb;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #2196f3;
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .btn:hover {
            background-color: #64b5f6;
            transform: scale(1.03);
        }

        .btn-danger {
            background-color: #ef5350;
        }
        .btn-danger:hover { background-color: #e57373; }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-bar form {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 400px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px 20px;
            background-color: #0f172a;
            border: 2px solid #1e3c72;
            border-radius: 50px;
            color: #fff;
            outline: none;
            font-family: inherit;
            font-size: 14px;
        }

        .search-bar input:focus {
            border-color: #2196f3;
        }

        .btn-search {
            background-color: #4caf50;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            font-family: inherit;
            transition: 0.3s;
        }
        .btn-search:hover { background-color: #66bb6a; }

        h3 {
            color: #90caf9;
            margin-bottom: 15px;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        table, th, td {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            font-size: 15px;
        }

        th {
            background-color: #1e3c72;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.03);
        }

        tr:nth-child(odd) {
            background-color: rgba(0, 0, 0, 0.15);
        }

        tr:hover {
            background-color: rgba(33, 150, 243, 0.15);
        }

        .badge-encrypt {
            background-color: #0f172a;
            color: #90caf9;
            padding: 5px 10px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 13px;
            border: 1px solid #1e3c72;
            display: inline-block;
        }

        .text-asli {
            color: #e3f2fd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Data Inventaris Barang Gudang</h2>
        <div class="user-info">
            Halo, <b><?php echo $_SESSION['username']; ?></b> | 
            <a href="tambah.php" class="btn">Tambah Barang</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="search-bar">
        <h3>Daftar Barang (Tersedia Data Enkripsi)</h3>
        <form action="" method="GET">
            <input type="text" name="cari" placeholder="Cari nama barang..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Barang</th>
                <th width="10%">Stok</th>
                <th width="25%">Catatan Suplier (Asli)</th>
                <th width="25%">Catatan Suplier (Terkripsi DB)</th>
                <th width="15%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if(isset($_GET['cari'])){
                $keyword = $_GET['cari'];
                $data = mysqli_query($koneksi, "SELECT * FROM inventaris_barang WHERE nama_barang LIKE '%$keyword%'");
            } else {
                $data = mysqli_query($koneksi, "SELECT * FROM inventaris_barang");
            }

            if(mysqli_num_rows($data) > 0){
                while($d = mysqli_fetch_array($data)){
                    $catatan_asli = decryptCaesar($d['catatan_suplier']);
                    $id_barang = $d['id_barang']; // Menggunakan id_barang sesuai tabel database
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama_barang']; ?></td>
                <td><?php echo $d['stok']; ?></td>
                <td class="text-asli"><b><?php echo $catatan_asli; ?></b></td>
                <td><span class="badge-encrypt"><?php echo $d['catatan_suplier']; ?></span></td>
                <td style="text-align: center;">
                    <a href="edit.php?id_barang=<?php echo $id_barang; ?>" style="background-color: #ffb300; color: #0f172a; padding: 5px 12px; border-radius: 15px; text-decoration: none; font-weight: bold; display: inline-block; margin-right: 4px;">Edit</a>
                    <a href="hapus.php?id_barang=<?php echo $id_barang; ?>" style="background-color: #ef5350; color: #ffffff; padding: 5px 12px; border-radius: 15px; text-decoration: none; font-weight: bold; display: inline-block;" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center; color: #ff8a80;'>Data tidak ditemukan!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>