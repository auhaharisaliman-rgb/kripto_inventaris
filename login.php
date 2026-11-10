<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Inventaris Gudang</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
        }

        body {
            /* Background luar menggunakan gradasi gelap elegan agar lingkaran login lebih menonjol */
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f2027 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Pembungkus berbentuk lingkaran dengan gradasi Biru ke Hitam */
        .circle-card {
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 50%, #000000 100%);
            width: 420px;
            height: 420px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* Efek bayangan cahaya lembut di sekitar lingkaran */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 20px rgba(41, 128, 185, 0.3);
            padding: 30px;
            color: white;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .circle-card h2 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        form {
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            width: 100%;
            margin-bottom: 12px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-size: 16px;
            margin-left: 15px;
            color: #e0e6ed;
        }

        /* Input berbentuk lingkaran panjang (kapsul) berwarna biru muda */
        .form-group input {
            width: 100%;
            padding: 10px 20px;
            background-color: #e3f2fd;
            border: 2px solid #90caf9;
            border-radius: 50px;
            font-size: 16px;
            color: #0d47a1;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            background-color: #ffffff;
            border-color: #2196f3;
            box-shadow: 0 0 8px rgba(33, 150, 243, 0.8);
        }

        /* Tombol OK kecil / minimalis */
        .btn-login {
            margin-top: 10px;
            padding: 8px 30px;
            background-color: #bbdefb;
            color: #0d47a1;
            border: none;
            border-radius: 20px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .btn-login:hover {
            background-color: #ffffff;
            transform: scale(1.05);
        }

        .error {
            color: #ff8a80;
            font-size: 14px;
            margin-bottom: 10px;
            background: rgba(0,0,0,0.4);
            padding: 4px 12px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="circle-card">
    <h2>Login Admin</h2>
    
    <?php 
    if(isset($_GET['pesan']) && $_GET['pesan'] == "gagal"){
        echo "<div class='error'>Username/Password Salah!</div>";
    }
    ?>

    <form action="proses_login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-login">OK</button>
    </form>
</div>

</body>
</html>