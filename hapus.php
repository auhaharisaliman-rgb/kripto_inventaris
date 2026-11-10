<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location: login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php';

$id_barang = $_GET['id_barang'];
mysqli_query($koneksi, "DELETE FROM inventaris_barang WHERE id_barang='$id_barang'");

header("location: index.php");
?>