<?php
session_start();
include 'koneksi.php';
include 'kripto.php';

// Menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password_input = $_POST['password'];

// Enkripsi password yang diinput user menggunakan Caesar Cipher agar sama dengan format di database
$password_encrypt = encryptCaesar($password_input);

// Cek data ke database
$query = mysqli_query($koneksi, "SELECT * FROM admin_gudang WHERE username='$username' AND password='$password_encrypt'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    // Jika data ditemukan, buat session login dan arahkan ke halaman utama
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("location: index.php");
} else {
    // Jika gagal, kembalikan ke halaman login dengan pesan error
    header("location: login.php?pesan=gagal");
}
?>